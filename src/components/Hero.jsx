import React, { useRef } from 'react';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import videoClip from '../assets/Clip1.mp4';

gsap.registerPlugin(ScrollTrigger);

const Hero = () => {
    const containerRef = useRef(null);
    const headingRef = useRef(null);
    const awardsRef = useRef(null);
    const videoContainerRef = useRef(null);

    useGSAP(() => {
        const tl = gsap.timeline();

        // Entrance Animation
        tl.from(headingRef.current, {
            y: 50,
            opacity: 0,
            duration: 1,
            ease: 'power3.out'
        })
        .from(awardsRef.current, {
            opacity: 0,
            duration: 1,
            ease: 'power3.out'
        }, '-=0.5')
        .from(videoContainerRef.current, {
            opacity: 0,
            duration: 1,
            ease: 'power3.out'
        }, '-=0.5');

        // Scroll Animation for Video
        gsap.to(videoContainerRef.current, {
            scale: 1.15,
            scrollTrigger: {
                trigger: containerRef.current,
                start: "top top",
                end: "bottom top",
                scrub: true
            }
        });

    }, { scope: containerRef });

    return (
        <section ref={containerRef} className="min-h-screen flex flex-col justify-center items-center text-center px-4 pt-44 pb-12 bg-[#f8f8f8]">
            <h1
                ref={headingRef}
                className="font-serif text-4xl md:text-6xl lg:text-7xl text-[#1a1a1a] leading-tight mb-24 max-w-4xl opacity-100"
            >
                a creation that <br /> <span className="italic">craves</span><br /> <span className="italic">creative</span> design.
            </h1>

            <div
                ref={awardsRef}
                className="flex flex-col items-center gap-6 mb-20 opacity-100"
            >
                <span className="text-[10px] uppercase tracking-widest text-gray-400">7x Agency of the Year</span>
                <div className="flex flex-wrap justify-center gap-x-6 gap-y-3 text-[10px] md:text-xs font-medium text-gray-500 tracking-wide font-sans">
                    <span>( ArchDaily 2024 )</span>
                    <span>( Pritzker Mention 2023 )</span>
                    <span>( Dezeen Awards 2024 )</span>
                    <span>( AIA Firm of Year 2025 )</span>
                </div>
            </div>

            <div
                ref={videoContainerRef}
                className="mt-20 mb-40 w-full max-w-6xl aspect-video md:aspect-[2.35/1] overflow-hidden rounded-lg shadow-2xl relative opacity-100"
            >
                <video
                    autoPlay
                    muted
                    loop
                    playsInline
                    className="w-full h-full object-cover"
                >
                    <source src={videoClip} type="video/mp4" />
                    {/* Fallback image */}
                    <img src="https://images.unsplash.com/photo-1486325212027-8081e485255e?q=80&w=2070&auto=format&fit=crop" className="w-full h-full object-cover" alt="Architecture" />
                </video>
                <div className="absolute inset-0 bg-black/10"></div>
            </div>
        </section>
    );
};

export default Hero;
