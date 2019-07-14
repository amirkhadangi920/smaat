import tilt from 'tilt.js'
import anime from 'animejs'
import Chart from 'chart.js'

export default {
  mounted()
  { 
    if (this.data().length === 0)
    {
      axios.post('/graphql/auth', {
        query: `{
          allData: ${this.plural} {
            data {
              id
              ${this.allQuery}

              ${ this.attr('has_timestamps') ? 'created_at updated_at' : ''}
            }
            chart {
              month
              count
            }
            total
            trash
          }
        }`
      })
      .then(({data}) => {
        this.setData(data.data.allData.data)

        this.setAttr('counts', {
          total: data.data.allData.total,
          trash: data.data.allData.trash,
        })

        this.setAttr('charts', {
          labels: data.data.allData.chart.map(period => period.month),
          data: data.data.allData.chart.map(period => period.count)
        })
      }).then(() => this.load(true))
      .then(() => $('.tilt').tilt({ scale: 1.05, maxTilt: 3 }))
      .then(() => {
        anime({
          targets: '.card i',
          rotate: '1turn',
          easing: 'linear',
          loop: true,
          duration: 200000,
        })
      })
      .then(() => this.createChart())
      .catch(error => console.log(error))
    }
    else
    {
      let data = this.data()
      this.setData([])
      this.load(false)

      setTimeout(() => {

        this.setData(data)
        this.load(true)
        
        setTimeout(() => {
          this.createChart()
        }, 200);
        
      }, 300)
    }
  },
  methods: {
    createChart() {
      let draw = Chart.controllers.line.prototype.draw;
      Chart.controllers.line = Chart.controllers.line.extend({
        draw: function () {
          draw.apply(this, arguments);
          let ctx = this.chart.chart.ctx;
          let _stroke = ctx.stroke;
          ctx.stroke = function () {
            ctx.save();
            ctx.shadowColor = '#2F80ED';
            ctx.shadowBlur = 15;
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 10;
            _stroke.apply(this, arguments)
            ctx.restore();
          }
        }
      });
      
      let ctx = document.getElementById("myChart").getContext('2d');

      const data = {
        labels: this.$store.state[this.group].charts[this.type].labels,
        datasets: [{
          data: this.$store.state[this.group].charts[this.type].data,
          // data: [3, 2, 5, 2, 6, 12, 3, 18, 9, 40, 2, 18],
          label: `تعداد ${this.label} های ثبت شده `,
          borderColor: '#56CCF2',
          pointBackgroundColor: "#fff",
          pointBorderColor: "#2F80ED",
          pointHoverBackgroundColor: "#ffb88c",
          pointHoverBorderColor: "#fff",
          pointRadius: 4,
          pointHoverRadius: 4,
          fill: false
        }]
      }

      let options = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false
        },
        tooltips: {
          bodySpacing: 4,
          mode: "nearest",
          intersect: 0,
          position: "nearest",
          xPadding: 10,
          yPadding: 10,
          caretPadding: 10
        },
        scales: {
          yAxes: [{
            display: 0,
            gridLines: 0,
            ticks: {
              display: false
            },
            gridLines: {
              zeroLineColor: "transparent",
              drawTicks: false,
              display: false,
              drawBorder: false
            }
          }],
          xAxes: [{
            display: true,
            // gridLines: 0,
            // ticks: {
            //   display: false
            // },
            // gridLines: {
            //   zeroLineColor: "transparent",
            //   drawTicks: false,
            //   display: false,
            //   drawBorder: false
            // }
          }]
        },
        layout: {
          padding: {
            left: 5,
            right: 10,
            top: 15,
            bottom: 0
          }
        }
      }

      this.chart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
      })
    },
    setData(data) {
      this.$store.commit('setData', {
        group: this.group,
        type: this.type,
        data: data
      })
    },
    setAttr(attr, data, override = false) {
      let final_data = typeof data === 'object' ? {
        ...this.$store.state[this.group][attr][this.type],
        ...data
      } : data;

      if (override) final_data = data

      this.$store.commit('setAttr', {
        attr,
        group: this.group,
        type: this.type,
        data: final_data
      })
    },
    can(permission) {
      return !this.$store.state.permissions.includes(permission)
    },

    data() {
      return this.$store.state[this.group][this.type]
    },
    attr(attr) {
      return this.$store.state[this.group][attr][this.type]
    },
    filter(filter) {
      return this.$store.state[this.group].filters[this.type][filter]
    },
    selected(field) {
      return this.$store.state[this.group].selected[this.type][field]
    },
    load(status) {
      this.setAttr('has_loaded', status)
    },
    changeTableData() {
      // 
    },
    handlePagination(page)
    {
      axios.post('/graphql/auth', {
        query: `{
          allData: ${this.plural} (page: ${page}) {
            data {
              id ${this.allQuery}
              ${ this.attr('has_timestamps') ? 'created_at updated_at' : ''}
            }
            total
          }
        }`
      })
      .then(({data}) => {
        this.setData(data.data.allData.data)

        this.setAttr('counts', { total: data.data.allData.total })

        this.setAttr('page', page)
      })
      .then(() => this.load(true) )
      .catch(error => console.log(error))
    },
    handleSearch(query)
    {
      if ( query.length >= 3 || query.length === 0  )
      {
        axios.post('/graphql/auth', {
          query: `{
            allData: ${this.plural} (query: "${query}") {
              data {
                id ${this.allQuery}
                ${ this.attr('has_timestamps') ? 'created_at updated_at' : ''}
              }
              total
            }
          }`
        })
        .then(({data}) => {
          this.setData(data.data.allData.data)
          this.setAttr('counts', { total: data.data.allData.total })
          this.setAttr('page', 1)
        })
        .then(() => this.load(true) )
        .catch(error => console.log(error))
      }

    }
  },
};
