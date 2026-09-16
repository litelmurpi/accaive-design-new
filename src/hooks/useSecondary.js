import { useState, useEffect } from "react";
import { fetchApi } from "../lib/api";
import { useSettingsContext } from "../context/SettingsContext";
import {
  FALLBACK_EXHIBITIONS,
  FALLBACK_PROGRAMS,
  FALLBACK_FEATURED_STORIES,
} from "../data/fallbackData";

export const useExhibitions = () => {
  const [exhibitions, setExhibitions] = useState(() => FALLBACK_EXHIBITIONS);
  const [loading, setLoading] = useState(true);
  useEffect(() => {
    fetchApi("/exhibitions")
      .then((data) => {
        if (Array.isArray(data) && data.length > 0) setExhibitions(data);
      })
      .catch(() => setExhibitions(FALLBACK_EXHIBITIONS))
      .finally(() => setLoading(false));
  }, []);
  return { exhibitions, loading };
};

export const usePress = () => {
  const [press, setPress] = useState([]);
  const [loading, setLoading] = useState(true);
  useEffect(() => {
    fetchApi("/press")
      .then(setPress)
      .catch(() => setPress([]))
      .finally(() => setLoading(false));
  }, []);
  return { press, loading };
};

export const usePrograms = () => {
  const [programs, setPrograms] = useState(() => FALLBACK_PROGRAMS);
  const [loading, setLoading] = useState(true);
  useEffect(() => {
    fetchApi("/programs")
      .then((data) => {
        if (Array.isArray(data) && data.length > 0) setPrograms(data);
      })
      .catch(() => setPrograms(FALLBACK_PROGRAMS))
      .finally(() => setLoading(false));
  }, []);
  return { programs, loading };
};

export const useFeaturedStories = () => {
  const [stories, setStories] = useState(() => FALLBACK_FEATURED_STORIES);
  const [loading, setLoading] = useState(true);
  useEffect(() => {
    fetchApi("/featured-stories")
      .then((data) => {
        if (Array.isArray(data) && data.length > 0) setStories(data);
      })
      .catch(() => setStories(FALLBACK_FEATURED_STORIES))
      .finally(() => setLoading(false));
  }, []);
  return { stories, loading };
};

export const useCareers = () => {
  const [careers, setCareers] = useState([]);
  const [loading, setLoading] = useState(true);
  useEffect(() => {
    fetchApi("/careers")
      .then(setCareers)
      .catch(() => setCareers([]))
      .finally(() => setLoading(false));
  }, []);
  return { careers, loading };
};

export const useSettings = () => {
  return useSettingsContext();
};
