import React from 'react';
import Contact from '../components/Contact';

const Careers = () => {
    const openings = [
        { title: "Senior Architect", type: "Full-time", location: "New York", desc: "Lead complex projects from concept to completion." },
        { title: "Interior Designer", type: "Full-time", location: "London", desc: "Create immersive interior environments for global brands." },
        { title: "Project Manager", type: "Full-time", location: "Remote", desc: "Oversee timelines and resources for international developments." },
        { title: "3D Visualizer", type: "Contract", location: "Berlin", desc: "Craft photorealistic renderings that bring visions to life." },
    ];

    return (
        <div className="pt-32">
            <div className="px-6 md:px-12 mb-20">
                <h1 className="font-serif text-5xl md:text-7xl lg:text-8xl leading-tight mb-8">Careers</h1>
                <p className="text-xl text-gray-600 max-w-2xl">
                    Join us in shaping the future of built environments.
                </p>
            </div>
            
            <div className="px-6 md:px-12 mb-20">
                {openings.map((job, idx) => (
                    <div key={idx} className="border-t border-gray-200 py-12 flex flex-col md:flex-row justify-between items-start md:items-center group cursor-pointer hover:bg-gray-50 transition-colors px-4 -mx-4">
                        <div className="mb-4 md:mb-0">
                            <h3 className="text-3xl font-serif mb-2">{job.title}</h3>
                            <p className="text-gray-500">{job.desc}</p>
                        </div>
                        <div className="flex flex-col items-end gap-2">
                            <div className="flex gap-4 text-sm uppercase tracking-widest text-gray-400">
                                <span>{job.location}</span>
                                <span>{job.type}</span>
                            </div>
                            <span className="text-sm uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity mt-2">Apply Now</span>
                        </div>
                    </div>
                ))}
                <div className="border-t border-gray-200"></div>
            </div>
            <Contact />
        </div>
    );
};

export default Careers;
