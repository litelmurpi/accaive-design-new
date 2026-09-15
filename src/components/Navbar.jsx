import React, { useRef } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { X } from 'lucide-react';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { useTheme } from '../context/useTheme';

gsap.registerPlugin(ScrollTrigger);

const Navbar = ({ toggleMenu, isMenuOpen }) => {
    const navRef = useRef(null);
    const { isDarkMode } = useTheme();
    const location = useLocation();

    // Dark-themed pages require white logo and white hamburger
    const isDarkPage = location.pathname.startsWith('/projects') || 
                       location.pathname.startsWith('/case-studies');

    const isDark = isDarkMode || isMenuOpen || isDarkPage;

    useGSAP(() => {
        const showAnim = gsap.from(navRef.current, { 
            yPercent: -100,
            paused: true,
            duration: 0.3,
            ease: "power2.out"
        }).progress(1);

        ScrollTrigger.create({
            start: "top top",
            end: 99999,
            onUpdate: (self) => {
                if (self.direction === -1) {
                    showAnim.play();
                } else {
                    showAnim.reverse();
                }
            }
        });
    }, { scope: navRef });

    return (
        <nav 
            ref={navRef}
            className={`fixed top-0 left-0 w-full px-6 py-6 md:px-12 md:py-8 lg:px-20 z-50 flex justify-between items-center transition-colors duration-300 ${isDark ? 'text-white' : 'text-black'}`}
        >
            <Link to="/" className="z-50 focus:outline-none">
                <img 
                    src="/logo-nav.png" 
                    alt="Accaive Logo" 
                    className={`w-32 md:w-40 transition-all duration-300 ${isDark ? 'brightness-100' : 'invert'}`} 
                />
            </Link>
            <button
                onClick={toggleMenu}
                className="z-50 hover:opacity-70 transition-opacity p-2 -mr-2 focus:outline-none cursor-pointer"
                aria-label={isMenuOpen ? "Tutup menu" : "Buka menu"}
            >
                {isMenuOpen ? (
                    <X size={24} strokeWidth={1.5} className="text-white" />
                ) : (
                    <div className="flex flex-col gap-1.5 w-8 items-end">
                        <span className={`w-full h-px block transition-colors duration-300 ${isDark ? 'bg-white' : 'bg-black'}`}></span>
                        <span className={`w-full h-px block transition-colors duration-300 ${isDark ? 'bg-white' : 'bg-black'}`}></span>
                    </div>
                )}
            </button>
        </nav>
    );
};

export default Navbar;
