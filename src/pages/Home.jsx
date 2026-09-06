import React, { useRef, useMemo } from 'react';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { useGSAP } from '@gsap/react';
import Hero from '../components/Hero';
import ServicesList from '../components/ServicesList';
import WorkGrid from '../components/WorkGrid';
import Team from '../components/Team';
import Contact from '../components/Contact';
import { useTheme } from '../context/useTheme';
import { useSettings } from '../hooks/useSecondary';

gsap.registerPlugin(ScrollTrigger);

const DEFAULT_SECTIONS = [
    { id: 'hero', is_visible: true },
    { id: 'services', is_visible: true },
    { id: 'projects', is_visible: true },
    { id: 'team', is_visible: true },
    { id: 'cta', is_visible: true },
];

const Home = () => {
    const workGridRef = useRef(null);
    const { setIsDarkMode } = useTheme();
    const { settings } = useSettings();

    const sections = useMemo(() => {
        if (!settings?.home_sections) return DEFAULT_SECTIONS;
        try {
            const parsed = typeof settings.home_sections === 'string'
                ? JSON.parse(settings.home_sections)
                : settings.home_sections;
            if (Array.isArray(parsed) && parsed.length > 0) {
                return parsed;
            }
        } catch {
            if (typeof settings.home_sections === 'string') {
                return settings.home_sections.split(',').map(id => ({ id: id.trim(), is_visible: true }));
            }
        }
        return DEFAULT_SECTIONS;
    }, [settings?.home_sections]);

    useGSAP(() => {
        if (!workGridRef.current) return;

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
            setIsDarkMode(false);
        };
    }, [setIsDarkMode, sections]);

    const renderSection = (section) => {
        if (section.is_visible === false || section.is_visible === 'false' || section.is_visible === 0) {
            return null;
        }

        switch (section.id) {
            case 'hero':
                return <Hero key="hero" />;
            case 'services':
                return <ServicesList key="services" />;
            case 'projects':
                return (
                    <div key="projects" ref={workGridRef}>
                        <WorkGrid />
                    </div>
                );
            case 'team':
                return <Team key="team" />;
            case 'cta':
                return <Contact key="cta" />;
            default:
                return null;
        }
    };

    return (
        <>
            {sections.map(renderSection)}
        </>
    );
};

export default Home;
