import { useState, useEffect } from "react";
import { fetchApi } from "../lib/api";

export const useExhibitions = () => {
  const [exhibitions, setExhibitions] = useState([]);
  const [loading, setLoading] = useState(true);
  useEffect(() => {
    fetchApi("/exhibitions")
      .then(setExhibitions)
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
      .finally(() => setLoading(false));
  }, []);
  return { press, loading };
};

export const usePrograms = () => {
  const [programs, setPrograms] = useState([]);
  const [loading, setLoading] = useState(true);
  useEffect(() => {
    fetchApi("/programs")
      .then(setPrograms)
      .finally(() => setLoading(false));
  }, []);
  return { programs, loading };
};

export const useFeaturedStories = () => {
  const [stories, setStories] = useState([]);
  const [loading, setLoading] = useState(true);
  useEffect(() => {
    fetchApi("/featured-stories")
      .then(setStories)
      .finally(() => setLoading(false));
  }, []);
  return { stories, loading };
};
