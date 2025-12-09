import React, { useRef } from 'react';
import { Link } from 'react-router-dom';
import { Menu, X } from 'lucide-react';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const Navbar = ({ toggleMenu, isMenuOpen }) => {
    const navRef = useRef(null);

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
            className={`fixed top-0 left-0 w-full px-6 py-6 md:px-12 md:py-8 lg:px-20 z-50 flex justify-between items-center transition-colors duration-300 ${isMenuOpen ? 'text-white' : 'text-white mix-blend-difference'}`}
        >
            <Link to="/" className="z-50">
                <img src="/logo-nav.png" alt="Accaive Logo" className="w-32 md:w-40" />
            </Link>
            <button
                onClick={toggleMenu}
                className="z-50 hover:opacity-70 transition-opacity"
            >
                {isMenuOpen ? (
                    <X size={24} strokeWidth={1} />
                ) : (
                    <div className="flex flex-col gap-1 w-8 items-end">
                        <span className="w-full h-px bg-current block"></span>
                        <span className="w-full h-px bg-current block"></span>
                    </div>
                )}
            </button>
        </nav>
    );
};

export default Navbar;
