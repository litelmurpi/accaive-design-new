import React, { useState, useRef, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { ArrowRight } from 'lucide-react';
import gsap from 'gsap';

const ServiceItem = ({ service, isActive, onActivate }) => {
    const contentRef = useRef(null);

    useEffect(() => {
        if (isActive) {
            gsap.to(contentRef.current, {
                height: 'auto',
                opacity: 1,
                marginTop: 16,
                duration: 0.5,
                ease: 'power2.out'
            });
        } else {
            gsap.to(contentRef.current, {
                height: 0,
                opacity: 0,
                marginTop: 0,
                duration: 0.5,
                ease: 'power2.out'
            });
        }
    }, [isActive]);

    return (
        <div
            className={`group py-8 border-b border-gray-200 cursor-pointer transition-all duration-300 ${isActive ? 'pl-4' : ''}`}
            onMouseEnter={onActivate}
        >
            <div className="flex justify-between items-center">
                <h3 className={`text-2xl md:text-4xl font-serif transition-colors ${isActive ? 'text-black' : 'text-gray-400'}`}>
                    {service.title}
                </h3>
                <span className={`text-sm transition-opacity ${isActive ? 'opacity-100' : 'opacity-0'}`}>
                    <ArrowRight size={20} />
                </span>
            </div>
            <div 
                ref={contentRef} 
                className="overflow-hidden h-0 opacity-0"
            >
                <p className="text-gray-600 text-lg font-light max-w-lg">{service.desc}</p>
            </div>
        </div>
    );
};

const ServicesList = () => {
    const services = [
        { id: "01", title: "Spatial Strategy", desc: "Aligning physical space with organizational vision." },
        { id: "02", title: "Adaptive Reuse", desc: "Breathing new life into historic structures." },
        { id: "03", title: "Urban Planning", desc: "Designing sustainable communities for the future." },
        { id: "04", title: "Interior Ecosystems", desc: "Curating environments that foster well-being." },
        { id: "05", title: "Brand Architecture", desc: "Translating brand identity into built form." }
    ];

    const [activeService, setActiveService] = useState(0);

    return (
        <section className="py-24 px-6 md:px-12 bg-white text-black">
            <div className="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <div className="lg:col-span-4">
                    <h2 className="text-xs uppercase tracking-widest text-gray-500 mb-8">Programs & Services</h2>
                    <p className="font-serif text-3xl md:text-4xl leading-tight mb-8">
                        Eleven ways we help clients build and command their unique environments.
                    </p>
                    <Link to="/programs" className="inline-block px-6 py-3 border bg-black text-white border-black rounded-full transition-all text-sm font-medium hover:scale-105 hover:shadow-lg">
                        Explore Programs
                    </Link>
                </div>
                
                <div className="lg:col-span-8">
                    <div className="flex flex-col">
                        {services.map((service, index) => (
                            <ServiceItem 
                                key={service.id} 
                                service={service} 
                                isActive={activeService === index} 
                                onActivate={() => setActiveService(index)} 
                            />
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
};

export default ServicesList;
