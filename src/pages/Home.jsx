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
        const st = ScrollTrigger.create({
            trigger: workGridRef.current,
            start: "top 60%",
            endTrigger: "body",
            end: "bottom bottom",
            onEnter: () => setIsDarkMode(true),
            onLeaveBack: () => setIsDarkMode(false),
        });

        return () => {
            st.kill();
            setIsDarkMode(false); // Clean reset when leaving home page
        };
    }, [setIsDarkMode]);

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
