import React from 'react';
import TeamMember from './TeamMember';

const Team = () => {
    const members = [
        { name: "Alex Vanhoven", role: "Principal Architect", img: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=2574&auto=format&fit=crop" },
        { name: "Sarah Chen", role: "Design Director", img: "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=2576&auto=format&fit=crop" },
        { name: "Marcus Thorne", role: "Urban Planner", img: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=2574&auto=format&fit=crop" },
        { name: "Elara Vance", role: "Interior Lead", img: "https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=2661&auto=format&fit=crop" },
        { name: "Davide Rosso", role: "Technical Director", img: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=2670&auto=format&fit=crop" },
        { name: "Priya Patel", role: "Sustainability Lead", img: "https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=2564&auto=format&fit=crop" },
    ];

    return (
        <section className="py-24 px-6 md:px-12 bg-white">
            <div className="flex flex-col md:flex-row justify-between items-end mb-16">
                <div>
                    <span className="text-xs uppercase tracking-widest text-gray-500 mb-2 block">Team</span>
                    <h2 className="font-serif text-5xl md:text-6xl">Meet the makers.</h2>
                </div>
                <p className="md:w-1/3 text-gray-600 mt-6 md:mt-0 leading-relaxed">
                    We asked our team to choose a piece of architecture that represents them. From brutalist monuments to sustainable dwellings. Different backgrounds, same high standards.
                </p>
            </div>

            <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-8">
                {members.map((member, idx) => (
                    <TeamMember key={idx} {...member} />
                ))}
            </div>
        </section>
    );
};

export default Team;
