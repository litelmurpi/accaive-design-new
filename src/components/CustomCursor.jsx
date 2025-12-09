import React, { useRef } from 'react';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';

const CustomCursor = () => {
    const cursorRef = useRef(null);
    const followerRef = useRef(null);

    useGSAP(() => {
        const cursor = cursorRef.current;
        const follower = followerRef.current;

        // Move cursor and follower
        const moveCursor = (e) => {
            gsap.to(cursor, {
                x: e.clientX,
                y: e.clientY,
                duration: 0.1,
                ease: 'power2.out'
            });
            gsap.to(follower, {
                x: e.clientX,
                y: e.clientY,
                duration: 0.5,
                ease: 'power2.out'
            });
        };

        window.addEventListener('mousemove', moveCursor);

        // Hover effect for links and buttons
        const handleHover = () => {
            gsap.to(cursor, { scale: 0.5, duration: 0.3 });
            gsap.to(follower, { scale: 3, backgroundColor: 'rgba(255, 255, 255, 0.1)', duration: 0.3 });
        };

        const handleUnhover = () => {
            gsap.to(cursor, { scale: 1, duration: 0.3 });
            gsap.to(follower, { scale: 1, backgroundColor: 'transparent', duration: 0.3 });
        };

        const links = document.querySelectorAll('a, button, .cursor-pointer');
        links.forEach(link => {
            link.addEventListener('mouseenter', handleHover);
            link.addEventListener('mouseleave', handleUnhover);
        });

        // Cleanup
        return () => {
            window.removeEventListener('mousemove', moveCursor);
            links.forEach(link => {
                link.removeEventListener('mouseenter', handleHover);
                link.removeEventListener('mouseleave', handleUnhover);
            });
        };
    }, { scope: cursorRef }); // Scope isn't strictly necessary for window events but good practice

    return (
        <>
            <div 
                ref={cursorRef} 
                className="fixed top-0 left-0 w-3 h-3 bg-white rounded-full pointer-events-none z-9999 mix-blend-difference -translate-x-1/2 -translate-y-1/2 hidden md:block"
            />
            <div 
                ref={followerRef} 
                className="fixed top-0 left-0 w-8 h-8 border border-white rounded-full pointer-events-none z-9998 mix-blend-difference -translate-x-1/2 -translate-y-1/2 transition-colors duration-300 hidden md:block"
            />
        </>
    );
};

export default CustomCursor;
