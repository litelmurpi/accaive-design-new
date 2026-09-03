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
                ease: 'power2.out',
                force3D: true
            });
            gsap.to(follower, {
                x: e.clientX,
                y: e.clientY,
                duration: 0.5,
                ease: 'power2.out',
                force3D: true
            });
        };

        window.addEventListener('mousemove', moveCursor);

        // Event delegation for hover effect
        const handleMouseOver = (e) => {
            if (e.target.closest('a, button, .cursor-pointer')) {
                gsap.to(cursor, { scale: 0.5, duration: 0.3 });
                gsap.to(follower, { scale: 3, backgroundColor: 'rgba(255, 255, 255, 0.1)', duration: 0.3 });
            }
        };

        const handleMouseOut = (e) => {
            if (e.target.closest('a, button, .cursor-pointer')) {
                gsap.to(cursor, { scale: 1, duration: 0.3 });
                gsap.to(follower, { scale: 1, backgroundColor: 'transparent', duration: 0.3 });
            }
        };

        document.addEventListener('mouseover', handleMouseOver);
        document.addEventListener('mouseout', handleMouseOut);

        // Cleanup
        return () => {
            window.removeEventListener('mousemove', moveCursor);
            document.removeEventListener('mouseover', handleMouseOver);
            document.removeEventListener('mouseout', handleMouseOut);
        };
    }, { scope: cursorRef }); 

    return (
        <>
            <div 
                ref={cursorRef} 
                className="fixed top-0 left-0 w-3 h-3 bg-white rounded-full pointer-events-none z-9999 mix-blend-difference -translate-x-1/2 -translate-y-1/2 hidden md:block will-change-transform"
            />
            <div 
                ref={followerRef} 
                className="fixed top-0 left-0 w-8 h-8 border border-white rounded-full pointer-events-none z-9998 mix-blend-difference -translate-x-1/2 -translate-y-1/2 transition-colors duration-300 hidden md:block will-change-transform"
            />
        </>
    );
};

export default CustomCursor;
