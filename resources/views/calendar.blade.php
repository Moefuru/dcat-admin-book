<style>
    .calendar{
        width:450px;
        height:350px;
        background:#fff;
        box-shadow:0px 1px 1px rgba(0,0,0,0.1);
    }
    .body-list ul{
        width:100%;
        font-family:arial;
        font-weight:bold;
        font-size:14px;
    }
    .body-list ul li{
        width:14.28%;
        height:36px;
        line-height:36px;
        list-style-type:none;
        display:block;
        box-sizing:border-box;
        float:left;
        text-align:center;
    }
    .lightgrey{
        color:#a8a8a8; /*浅灰色*/
    }
    .darkgrey{
        color:#565656; /*深灰色*/
    }
    .green{
        color:#6ac13c; /*绿色*/
    }
    .greenbox{
        border:1px solid #6ac13c;
        background:#e9f8df; /*浅绿色背景*/
    }
</style>

<div class="show-field form-group row">
    <div class="col-sm-2 control-label">
        <span>入住时间</span>
    </div>
    <div class="col-sm-8">
        <div class="calendar">
            <div class="title">
                <h1 class="green" id="calendar-title">Month</h1>
                <h2 class="green small" id="calendar-year">Year</h2>
                <a href="" id="prev">Prev Month</a>
                <a href="" id="next">Next Month</a>
            </div>
            <div class="body">
                <div class="lightgrey body-list">
                    <ul>
                        <li>MON</li>
                        <li>TUE</li>
                        <li>WED</li>
                        <li>THU</li>
                        <li>FRI</li>
                        <li>SAT</li>
                        <li>SUN</li>
                    </ul>
                </div>
                <div class="darkgrey body-list">
                    <ul id="days">
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var month_olympic = [31,29,31,30,31,30,31,31,30,31,30,31];
    var month_normal = [31,28,31,30,31,30,31,31,30,31,30,31];
    var month_name = ["January","Febrary","March","April","May","June","July","Auguest","September","October","November","December"];

    var holder = document.getElementById("days");
    var prev = document.getElementById("prev");
    var next = document.getElementById("next");
    var ctitle = document.getElementById("calendar-title");
    var cyear = document.getElementById("calendar-year");

    var my_date = new Date();
    var my_year = my_date.getFullYear();
    var my_month = my_date.getMonth();
    // var my_day = my_date.getDate();
    var my_day = {{$day}};

    //获取某年某月第一天是星期几
    function dayStart(month, year) {
        var tmpDate = new Date(year, month, 1);
        return (tmpDate.getDay());
    }

    //计算某年是不是闰年，通过求年份除以4的余数即可
    function daysMonth(month, year) {
        var tmp = year % 4;
        if (tmp == 0) {
            return (month_olympic[month]);
        } else {
            return (month_normal[month]);
        }
    }

    function refreshDate(){
        var str = "";
        var totalDay = daysMonth(my_month, my_year); //获取该月总天数
        var firstDay = dayStart(my_month, my_year); //获取该月第一天是星期几
        var myclass;
        for(var i=1; i<firstDay; i++){
            str += "<li></li>"; //为起始日之前的日期创建空白节点
        }
        for(var i=1; i<=totalDay; i++){
            if((i<my_day && my_year==my_date.getFullYear() && my_month==my_date.getMonth()) || my_year<my_date.getFullYear() || ( my_year==my_date.getFullYear() && my_month<my_date.getMonth())){
                myclass = " class='lightgrey'"; //当该日期在今天之前时，以浅灰色字体显示
            }else if (i==my_day && my_year==my_date.getFullYear() && my_month==my_date.getMonth()){
                myclass = " class='green greenbox'"; //当天日期以绿色背景突出显示
            }else{
                myclass = " class='darkgrey'"; //当该日期在今天之后时，以深灰字体显示
            }
            str += "<li"+myclass+">"+i+"</li>"; //创建日期节点
        }
        holder.innerHTML = str; //设置日期显示
        ctitle.innerHTML = month_name[my_month]; //设置英文月份显示
        cyear.innerHTML = my_year; //设置年份显示
    }
    refreshDate(); //执行该函数

    prev.onclick = function(e){
        e.preventDefault();
        my_month--;
        if(my_month<0){
            my_year--;
            my_month = 11;
        }
        refreshDate();
    }
    next.onclick = function(e){
        e.preventDefault();
        my_month++;
        if(my_month>11){
            my_year++;
            my_month = 0;
        }
        refreshDate();
    }

</script>
