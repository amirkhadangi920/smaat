import tilt from 'tilt.js'
import anime from 'animejs'
import Chart from 'chart.js'

export default {
  mounted() {    
    if (this.data().length === 0) {
      axios.get(`/api/v1/${this.type}`, {
        params: this.filters
      }).then(({data}) => {
        this.setData(data.data)

        this.setAttr('counts', {
          total: data.meta.total,
          trash: data.meta.trash,
        })

        this.setAttr('charts', {
          labels: data.chart.map(period => period.month),
          data: data.chart.map(period => period.count)
        })
        if (data.links && data.links.next === null)
          this.setAttr('has_more', false)

      }).then(() => {
        setTimeout(() => {
          this.load(true)

          $('.tilt').tilt({ scale: 1.1 })

          anime({
            targets: '.card i',
            rotate: '1turn',
            easing: 'linear',
            loop: true,
            duration: 200000,
          })

          setTimeout(() => {
            this.createChart()
          }, 100);
        }, 500)
      }).catch(error => console.log(error))
    } else {
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
            ctx.shadowColor = '#ffb88c';
            ctx.shadowBlur = 30;
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
          borderColor: '#ffb88c',
          pointBackgroundColor: "#fff",
          pointBorderColor: "#ffb88c",
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
      axios.get(`/api/v1/${this.type}`, {
        params: this.attr('filters')
      }).then((response) => {
        setTimeout(() => {
          this.setData(response.data.data)

          setTimeout(() => $('.tilt').tilt({
            scale: 1.1
          }), 300)
        }, 500);
      })
    },

    loadMore() {
      this.setPage({
        type: this.type,
        page: this.$store.state.feature.page[this.type] + 1
      })
      this.setLoadingSatus({
        type: this.type,
        status: true
      })

      axios.get(`/api/v1/${this.type}`, {
        params: {
          page: this.$store.state.feature.page[this.type],
        },
      }).then(({
        data
      }) => {
        setTimeout(() => {
          if (data.links.next === null) {
            this.setHasMoreStatus({
              type: this.type,
              status: false
            })
          }

          var time = 0;
          data.data.forEach(item => {
            setTimeout(() => {
              this.setFeature({
                type: this.type,
                data: [...this.$store.state.feature[this.type], item]
              })
            }, time)
            time += 200;
          });

          this.setLoadingSatus({
            type: this.type,
            status: false
          })
        }, 300)
      });
    },
  },
};
