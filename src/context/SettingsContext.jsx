import React, { createContext, useContext, useState, useEffect } from "react";
import { fetchApi } from "../lib/api";
import { getFallbackSettings } from "../data/fallbackData";

const SettingsContext = createContext(null);

export const SettingsProvider = ({ children }) => {
  const [settings, setSettings] = useState(() => getFallbackSettings());
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const loadSettings = async () => {
      try {
        setLoading(true);
        const data = await fetchApi("/settings");
        if (data && Object.keys(data).length > 0) {
          setSettings({ ...getFallbackSettings(), ...data });
        } else {
          setSettings(getFallbackSettings());
        }
      } catch (err) {
        console.warn("API unavailable, using offline fallback settings:", err?.message || err);
        setSettings(getFallbackSettings());
        setError(err);
      } finally {
        setLoading(false);
      }
    };

    loadSettings();

    const handleMessage = (event) => {
      if (event.data?.type === "ACCAIVE_SETTINGS_UPDATE" && event.data.payload) {
        setSettings((prev) => ({ ...prev, ...event.data.payload }));
      }
    };
    window.addEventListener("message", handleMessage);
    return () => window.removeEventListener("message", handleMessage);
  }, []);

  return (
    <SettingsContext.Provider value={{ settings, loading, error }}>
      {children}
    </SettingsContext.Provider>
  );
};

// eslint-disable-next-line react-refresh/only-export-components
export const useSettingsContext = () => {
  const context = useContext(SettingsContext);
  if (!context) {
    throw new Error("useSettingsContext must be used within a SettingsProvider");
  }
  return context;
};
