import React, { useRef, useState } from 'react';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';

const Preloader = ({ onComplete }) => {
    const containerRef = useRef(null);
    const textRef = useRef(null);
    const [progress, setProgress] = useState(0);

    useGSAP(() => {
        const tl = gsap.timeline({
            onComplete: () => {
                if (onComplete) onComplete();
            }
        });

        // Counter Animation
        const counter = { val: 0 };
        tl.to(counter, {
            val: 100,
            duration: 2,
            ease: "power2.inOut",
            onUpdate: () => {
                setProgress(Math.round(counter.val));
            }
        })
        .to(textRef.current, {
            opacity: 0,
            y: -20,
            duration: 0.5,
            ease: "power2.in"
        })
        .to(containerRef.current, {
            y: "-100%",
            duration: 1,
            ease: "power4.inOut"
        });

    }, { scope: containerRef });

    return (
        <div 
            ref={containerRef} 
            className="fixed inset-0 z-9999 bg-[#1a0f0a] flex justify-center items-center text-white"
        >
            <div ref={textRef} className="text-center">
                <div className="text-9xl font-serif font-bold mb-4">
                    {progress}%
                </div>
                <div className="text-xs uppercase tracking-[0.5em] text-white/50">
                    Loading Experience
                </div>
            </div>
        </div>
    );
};

export default Preloader;
