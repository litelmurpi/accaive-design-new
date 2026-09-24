import { useEffect } from 'react';

const DEFAULT_TITLE = 'Accaive Studio | Architecture & Built Environments';
const DEFAULT_DESC = 'Accaive Design Studio (accaivedesign.id) adalah biro arsitektur, interior, dan tata lingkungan visioner berbasis di Kotagede, Yogyakarta & Jakarta.';
const BASE_URL = 'https://accaivedesign.id';

export const usePageSEO = ({
  title,
  description,
  image,
  path = '',
  googleVerification,
} = {}) => {
  useEffect(() => {
    // 1. Update Document Title cleanly
    let formattedTitle = DEFAULT_TITLE;
    if (title) {
      if (title.toLowerCase().includes('accaive')) {
        formattedTitle = title;
      } else {
        formattedTitle = `${title} | Accaive Studio`;
      }
    }
    document.title = formattedTitle;

    // Helper to safely update or create meta tag
    const setMetaTag = (selector, attribute, value) => {
      if (!value) return;
      let tag = document.querySelector(selector);
      if (tag) {
        tag.setAttribute(attribute, value);
      } else {
        tag = document.createElement('meta');
        if (selector.startsWith('meta[name=')) {
          const name = selector.match(/name="([^"]+)"/)?.[1];
          if (name) tag.setAttribute('name', name);
        } else if (selector.startsWith('meta[property=')) {
          const prop = selector.match(/property="([^"]+)"/)?.[1];
          if (prop) tag.setAttribute('property', prop);
        }
        tag.setAttribute(attribute, value);
        document.head.appendChild(tag);
      }
    };

    // 2. Update Description
    const metaDesc = description || DEFAULT_DESC;
    setMetaTag('meta[name="description"]', 'content', metaDesc);
    setMetaTag('meta[property="og:description"]', 'content', metaDesc);
    setMetaTag('meta[name="twitter:description"]', 'content', metaDesc);

    // 3. Update OG Title
    setMetaTag('meta[property="og:title"]', 'content', formattedTitle);
    setMetaTag('meta[name="twitter:title"]', 'content', formattedTitle);

    // 4. Update Canonical & OG URL
    const canonicalUrl = path ? `${BASE_URL}${path.startsWith('/') ? path : '/' + path}` : `${BASE_URL}/`;
    let canonicalTag = document.querySelector('link[rel="canonical"]');
    if (canonicalTag) {
      canonicalTag.setAttribute('href', canonicalUrl);
    } else {
      canonicalTag = document.createElement('link');
      canonicalTag.setAttribute('rel', 'canonical');
      canonicalTag.setAttribute('href', canonicalUrl);
      document.head.appendChild(canonicalTag);
    }
    setMetaTag('meta[property="og:url"]', 'content', canonicalUrl);

    // 5. Update Image (if provided)
    if (image) {
      setMetaTag('meta[property="og:image"]', 'content', image);
      setMetaTag('meta[name="twitter:image"]', 'content', image);
    }

    // 6. Google Site Verification (if provided)
    if (googleVerification) {
      setMetaTag('meta[name="google-site-verification"]', 'content', googleVerification);
    }
  }, [title, description, image, path, googleVerification]);
};
