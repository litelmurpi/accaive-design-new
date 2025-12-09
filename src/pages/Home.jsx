import React, { useRef } from 'react';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { useGSAP } from '@gsap/react';
import Hero from '../components/Hero';
import ServicesList from '../components/ServicesList';
import WorkGrid from '../components/WorkGrid';
import Team from '../components/Team';
import Contact from '../components/Contact';
import { useTheme } from '../context/useTheme';

gsap.registerPlugin(ScrollTrigger);

const Home = () => {
    const workGridRef = useRef(null);
    const { setIsDarkMode } = useTheme();

    useGSAP(() => {
        // ScrollTrigger to detect when WorkGrid enters viewport
        ScrollTrigger.create({
            trigger: workGridRef.current,
            start: "top 80%", // Trigger when top of WorkGrid is 80% from top of viewport
            end: "top 20%",
            onEnter: () => setIsDarkMode(true),
            onLeaveBack: () => setIsDarkMode(false),
        });
    }, []);

    return (
        <>
            <Hero />
            <ServicesList />
            <div ref={workGridRef}>
                <WorkGrid />
            </div>
            <Team />
            <Contact />
        </>
    );
};

export default Home;
