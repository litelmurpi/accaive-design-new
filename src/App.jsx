import React, { useState, useEffect, lazy, Suspense } from "react";
import { Routes, Route, useLocation } from "react-router-dom";
import Lenis from "lenis";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import Navbar from "./components/Navbar";
import MenuOverlay from "./components/MenuOverlay";
import Footer from "./components/Footer";
import Preloader from "./components/Preloader";
import PageTransition from "./components/PageTransition";
import { ThemeProvider } from "./context/ThemeContext";
import { useTheme } from "./context/useTheme";
import { SettingsProvider } from "./context/SettingsContext";

// Lazy-loaded Pages for performance & code-splitting
const Home = lazy(() => import("./pages/Home"));
const CaseStudies = lazy(() => import("./pages/CaseStudies"));
const About = lazy(() => import("./pages/About"));
const Programs = lazy(() => import("./pages/Programs"));
const ArtsCulture = lazy(() => import("./pages/ArtsCulture"));
const TeamPage = lazy(() => import("./pages/TeamPage"));
const Careers = lazy(() => import("./pages/Careers"));
const Press = lazy(() => import("./pages/Press"));
const ContactForm = lazy(() => import("./pages/ContactForm"));
const ProjectDetail = lazy(() => import("./pages/ProjectDetail"));
const NotFound = lazy(() => import("./pages/NotFound"));

// Minimal elegant loading fallback
const PageFallback = () => (
  <div className="min-h-screen flex items-center justify-center">
    <div className="w-8 h-8 rounded-full border-2 border-white/20 border-t-white animate-spin" />
  </div>
);

function AppContent() {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [isLoading, setIsLoading] = useState(true);
  const location = useLocation();
  const { isDarkMode } = useTheme();

  const toggleMenu = () => setIsMenuOpen(!isMenuOpen);

  // Initialize Lenis and sync with GSAP
  useEffect(() => {
    const lenis = new Lenis({
      duration: 1.2,
      easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
      smoothWheel: true,
    });

    // Sync ScrollTrigger with Lenis
    lenis.on("scroll", ScrollTrigger.update);

    // Add Lenis to GSAP Ticker
    const rafCallback = (time) => {
      lenis.raf(time * 1000);
    };
    gsap.ticker.add(rafCallback);

    // Disable GSAP lag smoothing for better sync
    gsap.ticker.lagSmoothing(0);

    return () => {
      lenis.destroy();
      gsap.ticker.remove(rafCallback);
    };
  }, []);

  // Lock body scroll when menu is open
  useEffect(() => {
    if (isMenuOpen) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "unset";
    }
  }, [isMenuOpen]);

  // Scroll to top and refresh ScrollTrigger on route change
  useEffect(() => {
    window.scrollTo(0, 0);
    // Refresh ScrollTrigger positions with slight debounce for new page DOM
    const timer = setTimeout(() => {
      ScrollTrigger.refresh();
    }, 100);
    return () => clearTimeout(timer);
  }, [location.pathname]);

  return (
    <div
      className={`relative font-sans theme-wrapper ${
        isDarkMode ? "theme-dark dark" : "theme-light"
      }`}
    >
      {isLoading && <Preloader onComplete={() => setIsLoading(false)} />}

      <Navbar toggleMenu={toggleMenu} isMenuOpen={isMenuOpen} />
      <MenuOverlay isOpen={isMenuOpen} toggleMenu={toggleMenu} />

      <main>
        <PageTransition>
          <Suspense fallback={<PageFallback />}>
            <Routes>
              <Route path="/" element={<Home />} />
              <Route path="/case-studies" element={<CaseStudies />} />
              <Route path="/projects" element={<CaseStudies />} />
              <Route path="/about" element={<About />} />
              <Route path="/programs" element={<About />} />
              <Route path="/arts-culture" element={<ArtsCulture />} />
              <Route path="/team" element={<TeamPage />} />
              <Route path="/careers" element={<Careers />} />
              <Route path="/press" element={<Press />} />
              <Route path="/contact" element={<ContactForm />} />
              <Route path="/project/:slug" element={<ProjectDetail />} />
              <Route path="*" element={<NotFound />} />
            </Routes>
          </Suspense>
        </PageTransition>
      </main>

      <Footer />
    </div>
  );
}

function App() {
  return (
    <SettingsProvider>
      <ThemeProvider>
        <AppContent />
      </ThemeProvider>
    </SettingsProvider>
  );
}

export default App;
