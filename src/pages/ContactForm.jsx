import React, { useState, useRef } from "react";
import { useGSAP } from "@gsap/react";
import gsap from "gsap";
import { Send, ArrowLeft, Loader2 } from "lucide-react";
import { Link } from "react-router-dom";
import { useContact } from "../hooks/useContact";
import { useSettings } from "../hooks/useSecondary";

const ContactForm = () => {
  const { settings } = useSettings();
  const contactEmail = settings?.contact_email || "hello@accaivedesign.com";
  const containerRef = useRef(null);
  const formRef = useRef(null);
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    company: "",
    budget: "",
    message: "",
  });
  const {
    submitContact,
    loading: isSubmitting,
    success: isSubmitted,
  } = useContact();
  const [errorMessage, setErrorMessage] = useState("");

  useGSAP(
    () => {
      gsap.from(formRef.current, {
        y: 60,
        opacity: 0,
        duration: 1,
        ease: "power3.out",
      });
    },
    { scope: containerRef },
  );

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrorMessage("");
    try {
      await submitContact(formData);
    } catch (err) {
      setErrorMessage(err.message || "An error occurred.");
    }
  };

  if (isSubmitted) {
    return (
      <div
        ref={containerRef}
        className="min-h-screen bg-[#0a0a0a] text-white flex items-center justify-center px-6"
      >
        <div className="text-center max-w-xl">
          <div className="w-20 h-20 mx-auto mb-8 rounded-full bg-linear-to-br from-emerald-400 to-cyan-500 flex items-center justify-center">
            <Send size={32} />
          </div>
          <h1 className="font-serif text-4xl md:text-5xl mb-6">Thank You!</h1>
          <p className="text-xl text-gray-400 mb-8">
            We've received your message and will get back to you within 24
            hours.
          </p>
          <Link
            to="/"
            className="inline-flex items-center gap-2 px-6 py-3 border border-white/20 rounded-full hover:bg-white hover:text-black transition-all duration-300"
          >
            <ArrowLeft size={18} />
            Back to Home
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div
      ref={containerRef}
      className="min-h-screen bg-[#0a0a0a] text-white pt-32 pb-20 px-6 md:px-12"
    >
      <div className="max-w-4xl mx-auto">
        {/* Back Link */}
        <Link
          to="/"
          className="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors mb-12"
        >
          <ArrowLeft size={18} />
          Back
        </Link>

        {/* Header */}
        <div className="mb-16">
          <h1 className="font-serif text-5xl md:text-7xl mb-6">
            Start a <span className="italic text-gray-500">Project</span>
          </h1>
          <p className="text-xl text-gray-400 max-w-2xl">
            Tell us about your vision. We'll get back to you within 24 hours to
            discuss how we can bring it to life.
          </p>
        </div>

        {/* Form */}
        <form ref={formRef} onSubmit={handleSubmit} className="space-y-8">
          {errorMessage && (
            <div className="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded-md mb-8">
              {errorMessage}
            </div>
          )}
          {/* Name & Email Row */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="group">
              <label className="block text-sm text-gray-500 mb-2 uppercase tracking-wider">
                Name *
              </label>
              <input
                type="text"
                name="name"
                required
                value={formData.name}
                onChange={handleChange}
                className="w-full bg-transparent border-b-2 border-gray-700 py-4 text-xl focus:border-white transition-colors outline-none placeholder-gray-600"
                placeholder="John Doe"
              />
            </div>
            <div className="group">
              <label className="block text-sm text-gray-500 mb-2 uppercase tracking-wider">
                Email *
              </label>
              <input
                type="email"
                name="email"
                required
                value={formData.email}
                onChange={handleChange}
                className="w-full bg-transparent border-b-2 border-gray-700 py-4 text-xl focus:border-white transition-colors outline-none placeholder-gray-600"
                placeholder="john@company.com"
              />
            </div>
          </div>

          {/* Company & Budget Row */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="group">
              <label className="block text-sm text-gray-500 mb-2 uppercase tracking-wider">
                Company
              </label>
              <input
                type="text"
                name="company"
                value={formData.company}
                onChange={handleChange}
                className="w-full bg-transparent border-b-2 border-gray-700 py-4 text-xl focus:border-white transition-colors outline-none placeholder-gray-600"
                placeholder="Your Company"
              />
            </div>
            <div className="group">
              <label className="block text-sm text-gray-500 mb-2 uppercase tracking-wider">
                Budget Range
              </label>
              <select
                name="budget"
                value={formData.budget}
                onChange={handleChange}
                className="w-full bg-transparent border-b-2 border-gray-700 py-4 text-xl focus:border-white transition-colors outline-none text-gray-400 cursor-pointer"
              >
                <option value="" className="bg-[#0a0a0a]">
                  Select a range
                </option>
                <option value="5k-10k" className="bg-[#0a0a0a]">
                  $5,000 - $10,000
                </option>
                <option value="10k-25k" className="bg-[#0a0a0a]">
                  $10,000 - $25,000
                </option>
                <option value="25k-50k" className="bg-[#0a0a0a]">
                  $25,000 - $50,000
                </option>
                <option value="50k+" className="bg-[#0a0a0a]">
                  $50,000+
                </option>
              </select>
            </div>
          </div>

          {/* Message */}
          <div className="group">
            <label className="block text-sm text-gray-500 mb-2 uppercase tracking-wider">
              Tell us about your project *
            </label>
            <textarea
              name="message"
              required
              value={formData.message}
              onChange={handleChange}
              rows={5}
              className="w-full bg-transparent border-b-2 border-gray-700 py-4 text-xl focus:border-white transition-colors outline-none resize-none placeholder-gray-600"
              placeholder="Describe your vision, goals, and timeline..."
            />
          </div>

          {/* Submit Button */}
          <div className="pt-8">
            <button
              type="submit"
              disabled={isSubmitting}
              className="group relative px-10 py-5 bg-white text-black rounded-full overflow-hidden flex items-center gap-4 text-lg font-medium hover:bg-gray-100 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <span className="relative z-10">
                {isSubmitting ? "Sending..." : "Send Message"}
              </span>
              <Send
                className={`relative z-10 transition-transform ${
                  isSubmitting
                    ? "animate-pulse"
                    : "group-hover:translate-x-1 group-hover:-translate-y-1"
                }`}
                size={20}
              />
            </button>
          </div>
        </form>

        {/* Contact Info */}
        <div className="mt-24 pt-12 border-t border-gray-800">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
              <h3 className="text-sm text-gray-500 uppercase tracking-wider mb-3">
                Email
              </h3>
              <a
                href={`mailto:${contactEmail}`}
                className="text-lg hover:text-gray-400 transition-colors"
              >
                {contactEmail}
              </a>
            </div>
            <div>
              <h3 className="text-sm text-gray-500 uppercase tracking-wider mb-3">
                Phone
              </h3>
              <a
                href="tel:+1234567890"
                className="text-lg hover:text-gray-400 transition-colors"
              >
                +62 812-3456-7890
              </a>
            </div>
            <div>
              <h3 className="text-sm text-gray-500 uppercase tracking-wider mb-3">
                Location
              </h3>
              <p className="text-lg text-gray-400">Kotagede, Yogyakarta</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ContactForm;
