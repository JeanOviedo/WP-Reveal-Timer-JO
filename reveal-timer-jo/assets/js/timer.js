/**
 * WP Reveal Timer JS
 */

document.addEventListener('DOMContentLoaded', function() {
    const timers = document.querySelectorAll('.revetijo-timer-container');

    timers.forEach(function(timer) {
        let secondsLeft = parseInt(timer.getAttribute('data-seconds'));
        const countdownElement = timer.querySelector('.revetijo-timer-countdown');
        const headerElement = timer.querySelector('.revetijo-timer-header');
        const contentElement = timer.querySelector('.revetijo-timer-content');

        if (!countdownElement) return;

        function updateTimer() {
            countdownElement.textContent = formatTime(secondsLeft);

            if (secondsLeft <= 0) {
                clearInterval(interval);
                revealContent();
            }

            secondsLeft--;
        }

        function formatTime(totalSeconds) {
            const h = Math.floor(totalSeconds / 3600);
            const m = Math.floor((totalSeconds % 3600) / 60);
            const s = totalSeconds % 60;

            let result = "";
            if (h > 0) result += (h < 10 ? "0" + h : h) + ":";
            result += (m < 10 ? "0" + m : m) + ":";
            result += (s < 10 ? "0" + s : s);

            return result;
        }

        function revealContent() {
            headerElement.style.display = 'none';
            contentElement.style.display = 'block';
            contentElement.classList.add('revetijo-timer-reveal');
            
            // Trigger a resize event to ensure compatibility with Elementor/Slick/etc
            window.dispatchEvent(new Event('resize'));
        }

        const interval = setInterval(updateTimer, 1000);
        updateTimer(); // Initial call
    });
});
