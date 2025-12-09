import React from 'react';
import Contact from '../components/Contact';

const ArtsCulture = () => {
    const exhibitions = [
        { title: "Modern Heritage", location: "London, UK", year: "2023", img: "https://images.unsplash.com/photo-1518998053901-5348d3969105?q=80&w=2592&auto=format&fit=crop" },
        { title: "Light & Shadow", location: "Tokyo, Japan", year: "2022", img: "https://images.unsplash.com/photo-1507643179173-617d654f3daf?q=80&w=2668&auto=format&fit=crop" },
        { title: "The Silent Gallery", location: "Berlin, Germany", year: "2024", img: "https://images.unsplash.com/photo-1545989253-02cc26577f88?q=80&w=2670&auto=format&fit=crop" },
    ];

    return (
        <div className="pt-32">
            <div className="px-6 md:px-12 mb-20">
                <h1 className="font-serif text-5xl md:text-7xl lg:text-8xl leading-tight mb-8">Arts & Culture</h1>
                <p className="text-xl text-gray-600 max-w-2xl">
                    Exploring the intersection of design, heritage, and modern artistic expression.
                </p>
            </div>

            <div className="px-6 md:px-12 mb-20 space-y-24">
                {exhibitions.map((exhibit, idx) => (
                    <div key={idx} className="group grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div className={`overflow-hidden rounded-lg ${idx % 2 === 1 ? 'lg:order-2' : ''}`}>
                            <img 
                                src={exhibit.img} 
                                alt={exhibit.title} 
                                className="w-full aspect-video object-cover transition-transform duration-700 group-hover:scale-105"
                            />
                        </div>
                        <div className={idx % 2 === 1 ? 'lg:order-1' : ''}>
                            <div className="flex items-center gap-4 mb-4 text-sm uppercase tracking-widest text-gray-400">
                                <span>{exhibit.location}</span>
                                <span className="w-px h-4 bg-gray-300"></span>
                                <span>{exhibit.year}</span>
                            </div>
                            <h2 className="font-serif text-4xl md:text-5xl mb-6">{exhibit.title}</h2>
                            <p className="text-gray-600 text-lg leading-relaxed mb-8">
                                An immersive experience designed to challenge perceptions of space and time. 
                                Through careful curation of light, material, and sound, we created an environment 
                                that speaks to the soul of the visitor.
                            </p>
                            <button className="text-black border-b border-black pb-1 hover:opacity-60 transition-opacity">
                                View Exhibition
                            </button>
                        </div>
                    </div>
                ))}
            </div>

            <Contact />
        </div>
    );
};

export default ArtsCulture;
