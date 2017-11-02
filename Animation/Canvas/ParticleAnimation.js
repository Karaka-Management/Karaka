/**
 * Particle animation class.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";

    /** @namespace jsOMS.Animation.Canvas */
    jsOMS.Autoloader.defineNamespace('jsOMS.Animation.Canvas');

    /**
     *
     * @param {object} canvas Canvas
     *
     * @constructor
     *
     * @since 1.0.0
     */
    jsOMS.Animation.Canvas.ParticleAnimation = function (canvas)
    {
        this.canvas = canvas;
        this.ctx    = canvas.getContext('2d');
        
        /** global: screen */
        this.width  = screen.width;
        this.height = screen.height;

        this.canvas.width  = this.width;
        this.canvas.height = this.height;

        this.particles   = [];
        this.maxDistance = 70;
        this.gravitation = 10000000;

        for (let i = 0; i < this.width * this.height / 3000; i++) {
            this.particles.push(new jsOMS.Animation.Canvas.Particle(
                Math.random() * this.width,
                Math.random() * this.height,
                -1 + Math.random() * 2,
                -1 + Math.random() * 2,
                1
            ));
        }
    };

    /**
     * Draw everything
     *
     * @param {object} self Object reference for self invoke
     *
     * @return {void} 
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.Animation.Canvas.ParticleAnimation.prototype.draw = function (self)
    {
        self = typeof self !== 'undefined' ? self : this;
        self.invalidate();

        const length = self.particles.length;

        for (let i = 0; i < length; i++) {
            self.particles[i].draw(self.ctx);
        }

        self.updateParticles();
        jsOMS.Animation.Animation.requestAnimationFrame.call(window, function ()
        {
            self.draw(self);
        });
    };

    /**
     * Invalidate/clean canvas
     *
     * @return {void} 
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.Animation.Canvas.ParticleAnimation.prototype.invalidate = function ()
    {
        this.ctx.clearRect(0, 0, this.width, this.height);
    };

    /**
     * Update particle
     *
     * @return {void} 
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.Animation.Canvas.ParticleAnimation.prototype.updateParticles = function ()
    {
        let particle,
            pos,
            vel,
            radius;

        const length = this.particles.length;

        for (let i = 0; i < length; i++) {
            particle = this.particles[i];
            pos      = particle.getPosition();
            vel      = particle.getVelocity();
            radius   = particle.getRadius();

            pos.x += vel.x;
            pos.y += vel.y;

            // Change on wall hit
            if (pos.x + radius > this.width) {
                pos.x = radius;
            } else if (pos.x - radius < 0) {
                pos.x = this.width - radius;
            }

            if (pos.y + radius > this.height) {
                pos.y = radius;
            } else if (pos.y - radius < 0) {
                pos.y = this.height - radius;
            }

            particle.setPosition(pos.x, pos.y);
            particle.setVelocity(vel.x, vel.y);

            for (let j = i + 1; j < length; j++) {
                this.updateDistance(particle, this.particles[j]);
            }
        }
    };

    /**
     * Handle distance between particles
     *
     * @param {Particle} p1 Particle 
     * @param {Particle} p2 Particle
     *
     * @return {void} 
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.Animation.Canvas.ParticleAnimation.prototype.updateDistance = function (p1, p2)
    {
        const pos1 = p1.getPosition(),
            pos2 = p2.getPosition(),
            dx   = pos1.x - pos2.x,
            dy   = pos1.y - pos2.y,
            dist = Math.sqrt(dx * dx + dy * dy);

        let vel1 = p1.getVelocity(),
            vel2 = p2.getVelocity();

        // Draw line if particles are close
        if (dist <= this.maxDistance) {
            this.ctx.beginPath();
            this.ctx.strokeStyle = 'rgba(255, 255, 255, ' + ((1.2 - dist / this.maxDistance) * 0.5) + ')';
            this.ctx.moveTo(pos1.x, pos1.y);
            this.ctx.lineTo(pos2.x, pos2.y);
            this.ctx.stroke();
            this.ctx.closePath();

            // Accelerate based on distance (no acceleration yet)
            let ax = dx / this.gravitation,
                ay = dy / this.gravitation;

            vel1.x -= ax;
            vel1.y -= ay;
            p1.setVelocity(vel1.x, vel1.y);

            vel2.x -= ax;
            vel2.y -= ay;
            p2.setVelocity(vel2.x, vel2.y);
        }
    };
}(window.jsOMS = window.jsOMS || {}));