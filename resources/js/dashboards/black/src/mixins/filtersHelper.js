import moment from 'moment-jalaali';
import numeral from 'numeral'

export default {
    created() {
        moment.locale('fa')
    },
    filters: {
        created(date) {
            return 'ثبت شده در ' + moment(date, "YYYY-MM-DD hh:mm:ss").calendar();
        },
        edited(date) {
            return 'اصلاح شده در ' + moment(date, "YYYY-MM-DD hh:mm:ss").calendar();
        },
        ago(date) {
            return moment(date, "YYYY-MM-DD hh:mm:ss").fromNow();
        },
        comma(number) {
            return numeral(number).format('0,0')
        },
        price(price) {
            return price === 0 ? 'رایگان' : numeral(price).format('0,0')
        },
    }
}