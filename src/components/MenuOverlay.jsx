import React, { useRef } from 'react';
import { Link } from 'react-router-dom';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import { ArrowRight } from 'lucide-react';

const MenuOverlay = ({ isOpen, toggleMenu }) => {
    const containerRef = useRef(null);
    const linksRef = useRef([]);
    const secondaryLinksRef = useRef(null);
    const featuredRef = useRef(null);

    useGSAP(() => {
        const tl = gsap.timeline();

        if (isOpen) {
            // Open animation
            tl.to(containerRef.current, {
                y: 0,
                duration: 1,
                ease: 'power4.inOut'
            })
            .from(linksRef.current, {
                y: 100,
                opacity: 0,
                stagger: 0.1,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.4')
            .from([secondaryLinksRef.current, featuredRef.current], {
                y: 20,
                opacity: 0,
                duration: 0.8,
                stagger: 0.1,
                ease: 'power3.out'
            }, '-=0.6');
        } else {
            // Close animation
            tl.to(containerRef.current, {
                y: '-100%',
                duration: 0.8,
                ease: 'power4.inOut'
            });
        }
    }, { dependencies: [isOpen] });

    const menuItems = [
        { label: 'Case Studies', path: '/case-studies' },
        { label: 'Programs', path: '/programs' },
        { label: 'Arts & Culture', path: '/arts-culture' }
    ];

    const secondaryLinks = [
        { label: 'Team', path: '/team' },
        { label: 'Careers', path: '/careers' },
        { label: 'Press', path: '/press' }
    ];

    return (
        <div 
            ref={containerRef} 
            className="fixed inset-0 menu-overlay z-40 flex flex-col pt-24 px-6 md:px-12 overflow-y-auto text-[#e5e5e5] -translate-y-full"
        >
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 h-full">
                {/* Left Side: Navigation */}
                <div className="flex flex-col justify-between pb-12">
                    <div className="space-y-4">
                        {menuItems.map((item, idx) => (
                            <Link
                                key={item.label}
                                to={item.path}
                                onClick={toggleMenu}
                                ref={el => linksRef.current[idx] = el}
                                className="font-serif block text-5xl md:text-7xl lg:text-8xl hover:text-gray-400 transition-colors leading-tight"
                            >
                                {item.label}
                            </Link>
                        ))}
                    </div>

                    <div ref={secondaryLinksRef} className="mt-12 flex flex-wrap gap-6 text-sm md:text-base font-medium">
                        <button className="px-6 py-3 border border-white rounded-full hover:bg-white hover:text-black transition-all">
                            Work with us
                        </button>
                        {secondaryLinks.map(link => (
                            <Link 
                                key={link.label} 
                                to={link.path} 
                                onClick={toggleMenu}
                                className="py-3 px-2 hover:opacity-60 transition-opacity"
                            >
                                {link.label}
                            </Link>
                        ))}
                    </div>
                </div>

                {/* Right Side: Featured Stories */}
                <div ref={featuredRef} className="hidden lg:flex flex-col space-y-8 pb-12">
                    <div className="text-xs uppercase tracking-widest text-gray-500 mb-4">
                        Featured Stories
                    </div>

                    {[
                        { title: "The Vertical Forest", cat: "Sustainability", img: "https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=2070&auto=format&fit=crop" },
                        { title: "Museum of Light", cat: "Culture", img: "https://images.unsplash.com/photo-1506146332389-18140dc7b2fb?q=80&w=1964&auto=format&fit=crop" },
                        { title: "Adaptive Heritage", cat: "Restoration", img: "https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=2070&auto=format&fit=crop" }
                    ].map((story, idx) => (
                        <div
                            key={idx}
                            className="group flex gap-6 items-center cursor-pointer"
                        >
                            <div className="w-32 h-24 overflow-hidden rounded-md">
                                <img src={story.img} alt={story.title} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                            </div>
                            <div>
                                <div className="text-xs text-gray-400 uppercase tracking-wide mb-1">{story.cat}</div>
                                <h3 className="text-xl font-serif font-light group-hover:underline decoration-1 underline-offset-4">{story.title}</h3>
                            </div>
                            <div className="ml-auto opacity-0 group-hover:opacity-100 transition-opacity">
                                <ArrowRight size={20} />
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
};

export default MenuOverlay;
