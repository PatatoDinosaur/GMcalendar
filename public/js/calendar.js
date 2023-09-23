function generate_year_range(start, end) {
  var years = "";
  for (var year = start; year <= end; year++) {
      years += "<option value='" + year + "'>" + year + "</option>";
  }
  return years;
}

var today = new Date();
var currentMonth = today.getMonth();
var currentYear = today.getFullYear();
var selectYear = document.getElementById("year");
var selectMonth = document.getElementById("month");
var eventDate = new Date();

var createYear = generate_year_range(1970, 2200);

document.getElementById("year").innerHTML = createYear;

var calendar = document.getElementById("calendar");

calendar.addEventListener('click', function(event) {
  if(event.target.classList.contains('date-picker')) {
    var year = event.target.getAttribute('data-year');
    var month = event.target.getAttribute('data-month');
    var date = event.target.getAttribute('data-date');

  month = String(month).padStart(2,'0');
  date = String(date).padStart(2, '0');

    onDateClick(date);
    document.getElementById("eventDate").value=year+'-'+month+'-'+date;
    //event.target.classList.add("event-day");
    console.log(document.getElementById("eventDate").value);
  }
});


var lang = calendar.getAttribute('data-lang');

var months = ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"];
var days = ["日", "月", "火", "水", "木", "金", "土"];

var dayHeader = "<tr>";
for (day in days) {
  dayHeader += "<th data-days='" + days[day] + "'>" + days[day] + "</th>";
}
dayHeader += "</tr>";

document.getElementById("thead-month").innerHTML = dayHeader;

monthAndYear = document.getElementById("monthAndYear");
showCalendar(currentMonth, currentYear);

function next() {
  currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
  currentMonth = (currentMonth + 1) % 12;
  showCalendar(currentMonth, currentYear);
}

function previous() {
  currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
  currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
  showCalendar(currentMonth, currentYear);
}

function jump() {
  currentYear = parseInt(selectYear.value);
  currentMonth = parseInt(selectMonth.value);
  showCalendar(currentMonth, currentYear);
}

function onDateClick(date) {
  var eventForm = document.getElementById("eventForm");
  var eventDateInput = document.getElementById("eventDate");
  //eventDateInput.value = year + '-' + month + '-' + date;
  eventForm.style.display = "block";
}


function showCalendar(month, year) {

  var firstDay = ( new Date( year, month ) ).getDay();

  tbl = document.getElementById("calendar-body");

  tbl.innerHTML = "";

  monthAndYear.innerHTML = months[month] + "  " + year;
  selectYear.value = year;
  selectMonth.value = month;
  // creating all cells
  var date = 1;
  for ( var i = 0; i < 6; i++ ) {
      var row = document.createElement("tr");

      for ( var j = 0; j < 7; j++ ) {
          if ( i === 0 && j < firstDay ) {
              cell = document.createElement( "td" );
              cellText = document.createTextNode("");
              cell.appendChild(cellText);
              row.appendChild(cell);
          } else if (date > daysInMonth(month, year)) {
              break;
          } else {
              cell = document.createElement("td");
              cell.setAttribute("data-date", date);
              cell.setAttribute("data-month", month + 1);
              cell.setAttribute("data-year", year);
              cell.setAttribute("data-event", event);
              cell.setAttribute("data-month_name", months[month]);
              cell.className = "date-picker";
              cell.innerHTML = "<span>" + date + "</span>";
              if ( date === today.getDate() && year === today.getFullYear() && month === today.getMonth() ) {
                  cell.className = "date-picker selected";
              }
              if (date)
              row.appendChild(cell);
              date++;
          }
      }

      tbl.appendChild(row);
  }

    var events = document.querySelectorAll('.event');
    events.forEach(function(event) {
      var year = event.getAttribute('data-year');
      var month = event.getAttribute('data-month');
      var date = event.getAttribute('data-date');
      
      //month = String(month).padStart(2, '0');
      //date = String(date).padStart(2, '0');
      
      
      month = parseInt(month).toString();
      date = parseInt(date).toString();
      
      var cell = document.querySelector('.date-picker[data-year="' + year + '"][data-month="' + month + '"][data-date="' + date + '"]');
      console.log(month, date);
      if(cell) {
        cell.classList.add("event-day");
        var flag = document.createElement("span");
        flag.className = "event-flag";
        cell.appendChild(flag);
        console.log('success!');
      }
      else
        console.log('failed');
    });

}

function daysInMonth(iMonth, iYear) {
  return 32 - new Date(iYear, iMonth, 32).getDate();
}

function makeSchedule() {
  var eventDateInput = document.getElementById("eventDate");
  var eventTitleInput = document.getElementById("eventTitle");
  var eventTimeInput = document.getElementById("eventTime");
  var date = eventDateInput.value;
  var title = eventTitleInput.value;
  
  var eventForm = document.getElementById("eventForm");
  eventForm.style.display = "none";
  
  eventDateInput.value = "";
  eventTitleInput.value = "";
}

