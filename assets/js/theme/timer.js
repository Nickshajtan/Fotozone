var minuteLocale  = hcc_js_custom_params.minute;
var minutesLocale = hcc_js_custom_params.minutes;
var minutLocale   = hcc_js_custom_params.minut;

actionTimer(); //Timer

//Timer
function actionTimer(){
    try{
        var clocks = document.getElementsByClassName('clockdiv');
        if( clocks ){

            for( var i = 0; i < clocks.length; i++ ) 
            {
                var deadline = clocks[i].getAttribute('data-time');
                var id = clocks[i].getAttribute('id') + i;
                clocks[i].setAttribute('id', id);
                if( deadline ){
                    initializeClock(clocks[i].getAttribute('id'), deadline);
                }
                else{
                    clocks[i].querySelector('.time-message').classList.add('d-none');
                    clocks[i].querySelector('#deadline-messadge').classList.remove('d-none');
                }   
            }

            function getTimeRemaining(endtime) {
              var t = Date.parse(endtime) - Date.parse(new Date());
              var seconds = Math.floor((t / 1000) % 60);
              var minutes = Math.floor((t / 1000 / 60) % 60);
              var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
              var days = Math.floor(t / (1000 * 60 * 60 * 24));
              return {
                total: t,
                days: days,
                hours: hours,
                minutes: minutes,
                seconds: seconds
              };
            }

            function initializeClock(id, endtime) {
              var clock    = document.getElementById(id);
              var daysSpan = clock.querySelector(".days");
              var daysText = clock.querySelector(".days-text");
              var hoursSpan = clock.querySelector(".hours");
              var hoursText = clock.querySelector(".hours-text");
              var minutesSpan = clock.querySelector(".minutes");
              var minutesText = clock.querySelector(".minute-text");
              var secondsSpan = clock.querySelector(".seconds");
              var secondsText = clock.querySelector(".second-text");

              function updateClock() {
                var t = getTimeRemaining(endtime);

                if (t.total <= 0) {
                  var clocks =  document.getElementsByClassName("clockdiv");
                  for( var i = 0; i < clocks.length; i++ ) 
                  {
                        clocks[i].className = "d-none";
                        clocks[i].querySelector("deadline-messadge").className = "d-block";
                  }
                  clearInterval(timeinterval);
                  return true;
                }
                if(daysSpan){
                    daysSpan.innerHTML = t.days;
                }
                if(hoursSpan){
                    hoursSpan.innerHTML = ("0" + t.hours).slice(-2);
                }
               
                var minute = t.minutes;
                if( minute == 1 || minute == 21 || minute == 31 || minute == 41 || minute == 51 ){
                    if(minutesText){
                        minutesText.innerHTML = minuteLocale;
                    }
                }
                else if( minute == 2 || minute == 3 || minute == 4 || minute == 22 || minute == 23 || minute == 24 || minute == 32 || minute == 33 || minute == 34 || minute == 42 || minute == 43 || minute == 44  || minute == 52 || minute == 53 || minute == 54 || minute == 56 ){
                   if(minutesText){
                        minutesText.innerHTML = minutLocale; 
                   }
                }
                else{
                    if(minutesText){
                        minutesText.innerHTML = minutesLocale; 
                    }
                }
                if(minutesSpan){
                    minutesSpan.innerHTML = ("0" + t.minutes).slice(-2);
                }
                
                //secondsSpan.innerHTML = ("0" + t.seconds).slice(-2);
              }

              updateClock();
              var timeinterval = setInterval(updateClock, 1000);
            }   

        }
    }
    catch(e){
        console.log('Problem with Action Timer function');
    }
}  