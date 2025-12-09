import React, { useState, useRef, useEffect } from 'react';
import Contact from '../components/Contact';
import { ArrowRight, ArrowUpRight } from 'lucide-react';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

// Mock Data
const impacts = [
    "Establish Market Distinction",
    "Create Cultural Relevance",
    "Command Premium Pricing",
    "Optimize Portfolios",
    "Accelerate Growth",
    "Open Market Opportunity"
];

const programs = [
    { 
        id: 1,
        title: "Brand Refresh", 
        desc: "Stay Relevant. Stay Valuable.",
        color: "bg-blue-600",
        textColor: "text-white",
        image: "https://images.unsplash.com/photo-1555445054-d4b9b0c7c00e?q=80&w=1920&auto=format&fit=crop",
        longDesc: "If your brand is slowly becoming irrelevant, it's costing you 1-5% of market share every year. Our Brand Refresh Program stops the fade. We identify what still resonates, eliminate what doesn't, and evolve your brand to reclaim distinction.",
        metrics: [
            { label: "Rapid Top-line Growth", value: "3x", sub: "Aligning the business with its expression." },
            { label: "Improvement as 'Employer of Choice'", value: "2.5x", sub: "The refreshed brand drove a 2.5x lift in employee attraction." },
            { label: "Increased Brand Distinction", value: <ArrowUpRight className="w-12 h-12" />, sub: "Refreshed, the brand was more memorable." },
            { label: "Increase in Brand Recall", value: "34%", sub: "We enhanced a brand within a sea of sameness." }
        ]
    },
    { 
        id: 2,
        title: "Reposition", 
        desc: "Don’t Become the Best. Become the Only.",
        color: "bg-zinc-900",
        textColor: "text-white",
        image: "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1920&auto=format&fit=crop",
        longDesc: "Shift your market perception entirely. We help you move from a crowded category to a category of one.",
        metrics: [
            { label: "Market Shift", value: "100%", sub: "Total perception realignment." },
            { label: "New Leads", value: "4x", sub: "Attracting the right audience." }
        ]
    },
    { 
        id: 3,
        title: "Premiumization", 
        desc: "Elevate Every Signal.",
        color: "bg-purple-700",
        textColor: "text-white",
        image: "https://images.unsplash.com/photo-1550684848-fac1c5b4e853?q=80&w=1920&auto=format&fit=crop",
        longDesc: "Move upmarket by refining every touchpoint of your brand to command higher margins and better customers.",
        metrics: []
    },
    { title: "Expansion", desc: "Enter New Markets with an Edge.", color: "bg-green-700" },
    { title: "Turnaround", desc: "Make Your Next Move Your Turning Point.", color: "bg-orange-600" },
    { title: "Scale-Up", desc: "Go From Growing Pains to High Performance.", color: "bg-red-600" },
    { title: "Brand Creation", desc: "Build the Next Hottest Thing.", color: "bg-pink-600" },
    { title: "Architecture Restructure", desc: "Greater Portfolio Value. Less Confusion.", color: "bg-gray-800" },
    { title: "Value-Market Fit", desc: "Expand Your Value. Command Your Market.", color: "bg-indigo-600" },
    { title: "Exit (IPO/Sale)", desc: "Be Designed to Attract. Positioned to Sell.", color: "bg-teal-600" },
    { title: "Brand Merger", desc: "Turn an Addition Into a Multiplier.", color: "bg-yellow-600" }
];

const ProgramItem = ({ program, isActive, onToggle, onHover, onLeave, isDimmed }) => {
    const contentRef = useRef(null);
    
    useEffect(() => {
        if (isActive) {
            gsap.to(contentRef.current, {
                height: 'auto',
                opacity: 1,
                duration: 0.5,
                ease: 'power2.out'
            });
        } else {
            gsap.to(contentRef.current, {
                height: 0,
                opacity: 0,
                duration: 0.4,
                ease: 'power2.inOut'
            });
        }
    }, [isActive]);

    return (
        <div 
            className={`border-t border-gray-200 transition-opacity duration-300 ${isDimmed ? 'opacity-40' : 'opacity-100'}`}
            onMouseEnter={onHover}
            onMouseLeave={onLeave}
        >
            {/* Header Row */}
            <div 
                onClick={onToggle}
                className={`
                    cursor-pointer transition-all duration-300 px-6 md:px-12 py-6 group
                    ${isActive ? 'bg-black text-white pl-8 md:pl-16' : 'hover:bg-gray-50 hover:pl-8 md:hover:pl-16'}
                `}
            >
                <div className="max-w-7xl mx-auto flex items-center justify-between gap-8">
                    <div className="w-full md:w-1/3">
                        <h3 className={`font-serif text-2xl md:text-3xl transition-colors ${isActive ? 'text-white' : 'text-black'}`}>{program.title}</h3>
                    </div>
                    <div className="w-full md:w-1/3">
                        <p className={`text-base transition-colors ${ isActive ? 'text-white' : 'text-gray-400'}`}>{program.desc}</p>
                    </div>
                    <div className="w-full md:w-1/3 flex justify-end">
                        <ArrowRight className={`w-5 h-5 transition-all duration-300 ${isActive ? 'text-white' : ''} group-hover:translate-x-2`} />
                    </div>
                </div>
            </div>

            {/* Expanded Content */}
            <div 
                ref={contentRef}
                className="overflow-hidden h-0 opacity-0"
            >
                <div className={`${program.color || 'bg-black'} ${program.textColor || 'text-white'}`}>
                    <div className="max-w-7xl mx-auto px-6 md:px-12 py-16">
                        <div className="grid grid-cols-1 lg:grid-cols-2 gap-16">
                            
                            {/* Left Column: Image/Visual */}
                            <div className="relative aspect-4/3 w-full overflow-hidden rounded-sm">
                                {program.image ? (
                                    <img src={program.image} alt={program.title} className="w-full h-full object-cover" />
                                ) : (
                                    <div className="w-full h-full bg-white/10 flex items-center justify-center">
                                        <span className="text-2xl opacity-50">Visual Asset</span>
                                    </div>
                                )}
                            </div>

                            {/* Right Column: Data & Metrics */}
                            <div className="flex flex-col justify-between">
                                <div>
                                    <div className="flex gap-4 mb-8">
                                        <span className="text-xs font-bold uppercase tracking-widest border border-current px-3 py-1 rounded-full">Used for achieving</span>
                                    </div>
                                    <p className="text-xl md:text-2xl font-serif leading-relaxed mb-12 opacity-90">
                                        {program.longDesc || "We help brands find their focus, articulate their value, and design a future where they don't just compete, they lead."}
                                    </p>
                                </div>

                                {/* Metrics Grid */}
                                {program.metrics && program.metrics.length > 0 && (
                                    <div className="grid grid-cols-2 gap-8 border-t border-white/20 pt-8">
                                        {program.metrics.map((metric, mIdx) => (
                                            <div key={mIdx}>
                                                <div className="text-4xl md:text-6xl font-serif mb-2">{metric.value}</div>
                                                <div className="text-sm font-bold mb-1">{metric.label}</div>
                                                <div className="text-xs opacity-60 leading-relaxed">{metric.sub}</div>
                                            </div>
                                        ))}
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

const Programs = () => {
    const [activeProgram, setActiveProgram] = useState(null);
    const [hoveredIndex, setHoveredIndex] = useState(null);
    const [hoveredImpactIndex, setHoveredImpactIndex] = useState(null);
    const containerRef = useRef(null);
    const img1Ref = useRef(null);
    const img2Ref = useRef(null);
    const impactsRef = useRef(null);

    useGSAP(() => {
        // Floating Images Entrance
        gsap.to([img1Ref.current, img2Ref.current], {
            opacity: 1,
            duration: 1.5,
            stagger: 0.2,
            ease: "power2.out"
        });

        // Parallax Effect
        gsap.to(img1Ref.current, {
            y: -100,
            scrollTrigger: {
                trigger: containerRef.current,
                start: "top top",
                end: "bottom top",
                scrub: 1.5
            }
        });

        gsap.to(img2Ref.current, {
            y: -50,
            scrollTrigger: {
                trigger: containerRef.current,
                start: "top top",
                end: "bottom top",
                scrub: 1
            }
        });

        // Impact Text Reveal
        const impactHeadings = impactsRef.current.querySelectorAll('h4');
        gsap.from(impactHeadings, {
            opacity: 0.3,
            duration: 0.5,
            stagger: 0.1,
            scrollTrigger: {
                trigger: impactsRef.current,
                start: "top 80%",
                end: "bottom 20%",
                toggleActions: "play none none reverse"
            }
        });
    }, { scope: containerRef });

    const toggleProgram = (idx) => {
        setActiveProgram(activeProgram === idx ? null : idx);
    };

    return (
        <div ref={containerRef} className="bg-white text-black min-h-screen overflow-x-hidden">
            
            {/* 1. HERO SECTION WITH FLOATING IMAGES */}
            <div className="relative pt-40 pb-40 px-6 md:px-12 max-w-7xl mx-auto min-h-[80vh] flex flex-col justify-center">
                {/* Floating Images with Parallax */}
                <div 
                    ref={img1Ref}
                    className="hidden lg:block absolute top-10 right-0 w-80 h-96 z-10 opacity-0"
                >
                    <img 
                        src="https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?q=80&w=600&auto=format&fit=crop" 
                        alt="Art" 
                        className="w-full h-full object-cover rounded-sm shadow-xl rotate-6 hover:rotate-0 transition-transform duration-700 ease-out blur-[2px] opacity-80" 
                    />
                </div>
                <div 
                    ref={img2Ref}
                    className="hidden lg:block absolute bottom-20 left-10 w-64 h-80 z-10 opacity-0"
                >
                    <img 
                        src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=600&auto=format&fit=crop" 
                        alt="Abstract" 
                        className="w-full h-full object-cover rounded-sm shadow-xl -rotate-3 hover:rotate-0 transition-transform duration-700 ease-out blur-[2px] opacity-80" 
                    />
                </div>
                
                {/* Text Content */}
                <div className="relative z-20">
                    <h1 className="font-serif text-sm font-bold tracking-[0.2em] uppercase mb-16 text-gray-500 flex items-center gap-4">
                        <span className="w-12 h-px bg-gray-400"></span>
                        Programs
                    </h1>
                    <p className="text-5xl md:text-7xl lg:text-9xl font-serif leading-[0.95] tracking-tight max-w-6xl">
                        Eleven ways we help brands find and command their <span className="italic text-gray-600">unique premium.</span>
                    </p>
                </div>
            </div>

            {/* 2. IMPACT SECTION */}
            <div className="px-6 md:px-12 mb-40 max-w-7xl mx-auto">
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-12">
                    <div className="lg:col-span-4 sticky top-10 h-fit">
                        <h3 className="text-sm font-medium text-gray-400 uppercase tracking-wider">Our Programs Deliver Impact</h3>
                    </div>
                    <div className="lg:col-span-8">
                        <div ref={impactsRef} className="grid grid-cols-1 gap-8">
                            {impacts.map((impact, idx) => (
                                <h4 
                                    key={idx}
                                    onMouseEnter={() => setHoveredImpactIndex(idx)}
                                    onMouseLeave={() => setHoveredImpactIndex(null)}
                                    className={`
                                        text-3xl md:text-5xl lg:text-6xl font-serif text-black cursor-default 
                                        transition-all duration-300 hover:scale-105 origin-left hover:text-black
                                        ${
                                            hoveredImpactIndex !== null && hoveredImpactIndex !== idx
                                                ? 'opacity-30'
                                                : 'opacity-100'
                                        }
                                    `}
                                >
                                    {impact}
                                </h4>
                            ))}
                        </div>
                    </div>
                </div>
            </div>

            {/* 3. PROGRAMS LIST (ACCORDION STYLE) */}
            <div className="w-full mb-32">
                <div className="flex flex-col">
                    {programs.map((program, idx) => (
                        <ProgramItem 
                            key={idx} 
                            program={program} 
                            isActive={activeProgram === idx} 
                            onToggle={() => toggleProgram(idx)}
                            onHover={() => setHoveredIndex(idx)}
                            onLeave={() => setHoveredIndex(null)}
                            isDimmed={hoveredIndex !== null && hoveredIndex !== idx} 
                        />
                    ))}
                    <div className="border-t border-gray-200"></div>
                </div>
            </div>

            <Contact />
        </div>
    );
};

export default Programs;