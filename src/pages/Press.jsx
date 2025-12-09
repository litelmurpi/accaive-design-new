import React from 'react';
import Contact from '../components/Contact';

const Press = () => {
    const articles = [
        { source: "ArchDaily", date: "Oct 2024", title: "Accaive named Agency of the Year", link: "#" },
        { source: "Dezeen", date: "Sep 2024", title: "The future of sustainable urban living: An interview with Alex Vanhoven", link: "#" },
        { source: "Wallpaper*", date: "Aug 2024", title: "Inside the Void House: A masterclass in minimalism", link: "#" },
        { source: "Architectural Digest", date: "Jul 2024", title: "Top 10 Emerging Firms to Watch", link: "#" },
        { source: "The New York Times", date: "Jun 2024", title: "Reimagining Public Spaces in a Post-Pandemic World", link: "#" },
    ];

    return (
        <div className="pt-32">
            <div className="px-6 md:px-12 mb-20">
                <h1 className="font-serif text-5xl md:text-7xl lg:text-8xl leading-tight mb-8">Press</h1>
                <p className="text-xl text-gray-600 max-w-2xl">
                    Latest news, awards, and features.
                </p>
            </div>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-16 px-6 md:px-12 mb-20">
                {articles.map((article, idx) => (
                    <div key={idx} className="border-t border-gray-200 pt-6 group cursor-pointer">
                        <div className="flex justify-between items-center mb-4 text-xs uppercase tracking-widest text-gray-400">
                            <span>{article.source}</span>
                            <span>{article.date}</span>
                        </div>
                        <h3 className="text-3xl font-serif mb-6 group-hover:text-gray-600 transition-colors leading-tight">{article.title}</h3>
                        <a href={article.link} className="text-sm underline decoration-gray-300 underline-offset-4 group-hover:decoration-black transition-all">Read Article</a>
                    </div>
                ))}
            </div>
            <Contact />
        </div>
    );
};

export default Press;
