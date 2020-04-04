<script type="text/javascript">
     var fecha=new Date('2018','10','02','17','45','00')
     var hoy=new Date()
     var dias=0
     var horas=0
     var minutos=0
     var segundos=0


        var upgradeTime=(fecha.getTime()-hoy.getTime())/1000
                //var upgradeTime = 365779;
                var seconds = upgradeTime;
                function timer() {
                    var days        = Math.floor(seconds/24/60/60);
                    var hoursLeft   = Math.floor((seconds) - (days*86400));
                    var hours       = Math.floor(hoursLeft/3600);
                    var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
                    var minutes     = Math.floor(minutesLeft/60);
                    var remainingSeconds = seconds % 60;
                    if (remainingSeconds < 10) {
                        remainingSeconds = "0" + remainingSeconds;
                    }
                    document.getElementById('countdown').innerHTML = "<span class='dias'>" + days + "<i>días</i></span><span class='horas'>" + hours + "<i>horas</i></span><span class='mins'>" + minutes + "<i>min</i></span><span class='segs'>" + parseInt(remainingSeconds) + "<i>seg</i></div>";
                    if (seconds <= 0) {
                        clearInterval(countdownTimer);
                        //document.getElementById('countdown').innerHTML = "<a class='text-light en-directo' href='/directos/atletico-de-madrid-alaves-16-12-2017-20-45'>En directo</a>";
                        $(".faltan").hide();
                    } else {
                        seconds--;
                    }
                }
            var countdownTimer = setInterval('timer()', 1000);
        </script>