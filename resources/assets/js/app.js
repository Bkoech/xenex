
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});

!function(a){a.fn.datepicker.dates["zh-TW"]={days:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],daysShort:["週日","週一","週二","週三","週四","週五","週六"],daysMin:["日","一","二","三","四","五","六"],months:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],monthsShort:["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],today:"今天",format:"yyyy年mm月dd日",weekStart:1,clear:"清除"}}(jQuery);
$('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    language: 'zh-TW'
});