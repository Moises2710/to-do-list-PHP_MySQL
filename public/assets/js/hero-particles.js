document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('heroParticlesCanvas');
    const heroSection = document.querySelector('.hero-section');
    if (!canvas || !heroSection) return;

    const ctx = canvas.getContext('2d');
    let width = 0;
    let height = 0;
    let particles = [];
    let mouse = { x: -1000, y: -1000, isHovering: false };
    let colorAngle = 0;

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
            this.radius = Math.random() * 2.5 + 0.8;
            this.speedY = -(Math.random() * 0.5 + 0.2);
            this.speedX = (Math.random() - 0.5) * 0.4;
            this.alpha = Math.random() * 0.6 + 0.2;
            this.maxAlpha = this.alpha;
            this.fadeSpeed = Math.random() * 0.005 + 0.002;
            this.hue = Math.floor(Math.random() * 60) + 240; // 240-300: Violet to Indigo / Cyan
            this.pulse = Math.random() * Math.PI;
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
                const maxDist = 140;

                if (dist < maxDist) {
                    const force = (maxDist - dist) / maxDist;
                    const angle = Math.atan2(dy, dx);
                    // Push away slightly with magnetic swirl
                    this.x -= Math.cos(angle) * force * 3;
                    this.y -= Math.sin(angle) * force * 3;
                    this.alpha = Math.min(1, this.alpha + force * 0.5);
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
            ctx.fillStyle = `hsla(${this.hue}, 85%, 75%, ${this.alpha})`;
            ctx.shadowColor = `hsla(${this.hue}, 90%, 65%, 0.8)`;
            ctx.shadowBlur = 8;
            ctx.fill();
            ctx.shadowBlur = 0; // Reset shadow blur
        }
    }

    // Generate Dust Particles
    function initParticles() {
        const particleCount = Math.min(80, Math.floor((width * height) / 9000));
        particles = [];
        for (let i = 0; i < particleCount; i++) {
            particles.push(new DustParticle());
        }
    }

    // Dynamic Color Shift Gradient
    function drawBackgroundGradient() {
        colorAngle = (colorAngle + 0.2) % 360;
        const color1 = `hsl(${(240 + Math.sin(colorAngle * 0.01) * 30)}, 70%, 12%)`;
        const color2 = `hsl(${(270 + Math.cos(colorAngle * 0.01) * 30)}, 65%, 8%)`;
        const color3 = `hsl(${(210 + Math.sin(colorAngle * 0.015) * 40)}, 80%, 15%)`;

        const grad = ctx.createLinearGradient(0, 0, width, height);
        grad.addColorStop(0, color1);
        grad.addColorStop(0.5, color2);
        grad.addColorStop(1, color3);

        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, width, height);

        // Render Cursor Glow Light when mouse is hovering
        if (mouse.isHovering) {
            const radialGrad = ctx.createRadialGradient(mouse.x, mouse.y, 0, mouse.x, mouse.y, 220);
            radialGrad.addColorStop(0, 'rgba(124, 58, 237, 0.35)');
            radialGrad.addColorStop(0.5, 'rgba(79, 70, 229, 0.15)');
            radialGrad.addColorStop(1, 'rgba(0, 0, 0, 0)');

            ctx.fillStyle = radialGrad;
            ctx.fillRect(0, 0, width, height);
        }
    }

    // Connect close dust particles with glowing light threads near cursor
    function drawConstellation() {
        if (!mouse.isHovering) return;

        for (let i = 0; i < particles.length; i++) {
            const p1 = particles[i];
            const dx = mouse.x - p1.x;
            const dy = mouse.y - p1.y;
            const dist = Math.sqrt(dx * dx + dy * dy);

            if (dist < 120) {
                ctx.beginPath();
                ctx.moveTo(p1.x, p1.y);
                ctx.lineTo(mouse.x, mouse.y);
                ctx.strokeStyle = `rgba(167, 139, 250, ${(1 - dist / 120) * 0.4})`;
                ctx.lineWidth = 1;
                ctx.stroke();
            }
        }
    }

    function animate() {
        ctx.clearRect(0, 0, width, height);
        drawBackgroundGradient();

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
