class BeatPlayer {
    constructor(container) {
        this.container = container;
        this.playBtn = container.querySelector('.player-btn');
        this.timeText = container.querySelector('.time-text');
        this.audioSrc = container.dataset.src;
        this.init();
    }

    init() {
        this.wavesurfer = WaveSurfer.create({
            container: this.container.querySelector('.waveform'),
            waveColor: '#65d36e44',
            progressColor: '#65d36e',
            height: 50,
            barWidth: 2,
            barGap: 1,
            barRadius: 2,
            responsive: true,
            hideScrollbar: true,
            cursorWidth: 0,
            backend: 'MediaElement',
            normalize: true,
            fillParent: true,
            mediaControls: false
        });

        this.setupEvents();
        this.wavesurfer.load(this.audioSrc);
    }

    setupEvents() {
        // Deshabilitar botón hasta que el audio esté listo
        this.playBtn.disabled = true;

        this.wavesurfer.on('ready', () => {
            this.playBtn.disabled = false;
        });

        this.playBtn.addEventListener('click', () => {
            this.wavesurfer.playPause();
        });

        this.wavesurfer.on('play', () => {
            this.playBtn.innerHTML = '<i class="bi bi-pause-fill text-2xl"></i>';
            this.playBtn.classList.add('play');
            this.playBtn.classList.remove('paused');
        });

        this.wavesurfer.on('pause', () => {
            this.playBtn.innerHTML = '<i class="bi bi-play-fill text-2xl"></i>';
            this.playBtn.classList.remove('play');
            this.playBtn.classList.add('paused');
        });

        this.wavesurfer.on('audioprocess', () => {
            if (this.timeText) {
                this.timeText.textContent = this.formatTime(this.wavesurfer.getCurrentTime());
            }
        });

        this.wavesurfer.on('finish', () => {
            this.wavesurfer.seekTo(0);
            this.playBtn.innerHTML = '<i class="bi bi-play-fill text-2xl"></i>';
            this.playBtn.classList.remove('play');
            this.playBtn.classList.add('paused');
            if (this.timeText) this.timeText.textContent = '0:00';
        });
    }

    formatTime(seconds) {
        if (typeof seconds !== 'number') return '0:00';
        seconds = Math.floor(seconds);
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
    }
}

// Inicializar todos los reproductores en la página
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.player-container').forEach(container => {
        new BeatPlayer(container);
    });
});