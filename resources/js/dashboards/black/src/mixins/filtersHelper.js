import moment from 'moment-jalaali';
import numeral from 'numeral'

export default {
    created() {
        moment.locale('fa')
    },
    filters: {
        created(date) {
            return 'ثبت شده در ' + moment(date, "YYYY-MM-DD ساعت HH:mm:ss").format('jYYYY/jM/jD ساعت HH:mm:ss');
        },
        edited(date) {
            return 'اصلاح شده در ' + moment(date, "YYYY-MM-DD ساعت HH:mm:ss").format('jYYYY/jM/jD ساعت HH:mm:ss');
        },
        time(date, label) {
            return `${label} در ` + moment(date, "YYYY-MM-DD ساعت HH:mm:ss").format('jYYYY/jM/jD ساعت HH:mm:ss');
        },
        jalaali(date) {
            return moment( date ).format('jYYYY-jMM-jDD HH:mm:ss')
        },
        ago(date) {
            return moment(date, "YYYY-MM-DD hh:mm:ss").fromNow();
        },
        timestampAgo(date) {
            return moment(date * 1000).fromNow();
        },
        comma(number) {
            return numeral(number).format('0,0')
        },
        price(price) {
            return price === 0 ? 'رایگان' : numeral(price).format('0,0')
        },
    }
}