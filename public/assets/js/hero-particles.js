document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('heroParticlesCanvas');
    const heroSection = document.querySelector('.hero-section');
    if (!canvas || !heroSection) return;

    const ctx = canvas.getContext('2d');
    let width = 0;
    let height = 0;
    let particles = [];
    let mouse = { x: -1000, y: -1000, isHovering: false };

    // Brand Checkbox Palette (Indigo #4f46e5, Purple #7c3aed, Electric Blue #2563eb)
    const brandColors = [
        { h: 243, s: 75, l: 59, rgb: '79, 70, 229' },  // Indigo #4f46e5
        { h: 262, s: 83, l: 58, rgb: '124, 58, 237' }, // Purple #7c3aed
        { h: 217, s: 91, l: 60, rgb: '37, 99, 235' }   // Electric Blue #2563eb
    ];

    function resizeCanvas() {
        width = heroSection.offsetWidth;
        height = heroSection.offsetHeight;
        canvas.width = width * window.devicePixelRatio;
        canvas.height = height * window.devicePixelRatio;
        ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
    }

    class DustParticle {
        constructor() {
            this.reset(true);
        }

        reset(initial = false) {
            this.x = Math.random() * width;
            this.y = initial ? Math.random() * height : height + 10;
            this.radius = Math.random() * 2.8 + 1.2;
            this.speedY = -(Math.random() * 0.5 + 0.2);
            this.speedX = (Math.random() - 0.5) * 0.5;
            this.alpha = Math.random() * 0.5 + 0.3;
            this.maxAlpha = this.alpha;
            this.pulse = Math.random() * Math.PI;

            // Pick a brand color from the checkbox palette
            this.colorScheme = brandColors[Math.floor(Math.random() * brandColors.length)];
        }

        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            this.pulse += 0.03;

            // Twinkle / Pulse opacity
            this.alpha = this.maxAlpha * (0.6 + 0.4 * Math.sin(this.pulse));

            // Mouse hover attraction & repulse physics
            if (mouse.isHovering) {
                const dx = mouse.x - this.x;
                const dy = mouse.y - this.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                const maxDist = 160;

                if (dist < maxDist) {
                    const force = (maxDist - dist) / maxDist;
                    const angle = Math.atan2(dy, dx);
                    // Push away slightly with magnetic swirl
                    this.x -= Math.cos(angle) * force * 3.5;
                    this.y -= Math.sin(angle) * force * 3.5;
                    this.alpha = Math.min(1, this.alpha + force * 0.6);
                }
            }

            // Wrap around / Reset
            if (this.y < -10 || this.x < -10 || this.x > width + 10) {
                this.reset(false);
            }
        }

        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            ctx.fillStyle = `hsla(${this.colorScheme.h}, ${this.colorScheme.s}%, ${this.colorScheme.l}%, ${this.alpha})`;
            ctx.shadowColor = `rgba(${this.colorScheme.rgb}, 0.6)`;
            ctx.shadowBlur = mouse.isHovering ? 10 : 4;
            ctx.fill();
            ctx.shadowBlur = 0; // Reset shadow blur
        }
    }

    // Generate Dust Particles
    function initParticles() {
        const particleCount = Math.min(85, Math.floor((width * height) / 8500));
        particles = [];
        for (let i = 0; i < particleCount; i++) {
            particles.push(new DustParticle());
        }
    }

    // Render White Background & Cursor Spotlight
    function drawBackground() {
        // Pure White Background
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, width, height);

        // Render soft subtle brand glow near mouse cursor on hover
        if (mouse.isHovering) {
            const radialGrad = ctx.createRadialGradient(mouse.x, mouse.y, 0, mouse.x, mouse.y, 220);
            radialGrad.addColorStop(0, 'rgba(124, 58, 237, 0.12)');
            radialGrad.addColorStop(0.5, 'rgba(79, 70, 229, 0.05)');
            radialGrad.addColorStop(1, 'rgba(255, 255, 255, 0)');

            ctx.fillStyle = radialGrad;
            ctx.fillRect(0, 0, width, height);
        }
    }

    // Connect close dust particles with brand colored light threads near cursor
    function drawConstellation() {
        if (!mouse.isHovering) return;

        for (let i = 0; i < particles.length; i++) {
            const p1 = particles[i];
            const dx = mouse.x - p1.x;
            const dy = mouse.y - p1.y;
            const dist = Math.sqrt(dx * dx + dy * dy);

            if (dist < 130) {
                ctx.beginPath();
                ctx.moveTo(p1.x, p1.y);
                ctx.lineTo(mouse.x, mouse.y);
                ctx.strokeStyle = `rgba(124, 58, 237, ${(1 - dist / 130) * 0.35})`;
                ctx.lineWidth = 1.2;
                ctx.stroke();
            }
        }
    }

    function animate() {
        ctx.clearRect(0, 0, width, height);
        drawBackground();

        particles.forEach(p => {
            p.update();
            p.draw();
        });

        drawConstellation();
        requestAnimationFrame(animate);
    }

    // Event Listeners for Hover and Mouse Motion
    heroSection.addEventListener('mousemove', (e) => {
        const rect = heroSection.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
        mouse.isHovering = true;
    });

    heroSection.addEventListener('mouseenter', () => {
        mouse.isHovering = true;
    });

    heroSection.addEventListener('mouseleave', () => {
        mouse.isHovering = false;
        mouse.x = -1000;
        mouse.y = -1000;
    });

    window.addEventListener('resize', () => {
        resizeCanvas();
        initParticles();
    });

    resizeCanvas();
    initParticles();
    animate();
});
