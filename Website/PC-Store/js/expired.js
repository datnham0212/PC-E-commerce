$(document).ready(function () {
    function Counter(options) {
        var timer;
        var seconds = options.seconds || 10;
        var onUpdateStatus = options.onUpdateStatus || function () { };
        var onCounterEnd = options.onCounterEnd || function () { };
        var onCounterStart = options.onCounterStart || function () { };

        function decrementCounter() {
            onUpdateStatus(seconds);
            if (seconds === 0) {
                stopCounter();
                onCounterEnd();
                return;
            }
            seconds--;
        }

        function startCounter() {
            onCounterStart();
            clearInterval(timer);
            timer = setInterval(decrementCounter, 1000);
            decrementCounter();
        }

        function stopCounter() {
            clearInterval(timer);
        }

        return {
            start: startCounter,
            stop: stopCounter
        };
    }

    var countdown = new Counter({
        seconds: 1800,
        onCounterStart: function () {
            // show pop up with a message 
        },
        onUpdateStatus: function (second) {
            // change the UI that displays the seconds remaining in the timeout 
        },
        onCounterEnd: function () {
            // show message that session is over, perhaps redirect or log out 
            $.ajax({
                type: 'GET',
                url: 'reset.php',
                success: function () {
                    location.href = "session_expired.php";
                }
            });
        }
    });
    countdown.start();

    $(".applyCoupon").submit(function (e) {
        e.preventDefault();
        var postdata = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'coupon.php',
            data: postdata,
            dataType: 'json',
            success: function (result) {
                var message, color;
                if (result.isSuccess) {
                    $('#totalFinal').html(result.totalFinal + ' DH');
                    message = 'Coupon appliqué avec succès !';
                    color = '#4a934a';
                } else if (result.couponApplyed) {
                    message = 'Vous avez déjà appliqué un coupon !';
                    color = '#ff4136';
                } else {
                    message = 'Coupon invalide !';
                    color = '#ff4136';
                }
                $('#couponValidity').css('color', color).html(message).show().delay(5000).fadeOut(400);
            }
        });
    });
});
