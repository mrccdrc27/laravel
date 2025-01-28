import React, { useState, useEffect } from 'react';
import axios from 'axios';

const CertificationCounter = () => {
  const [count, setCount] = useState(0);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchCertificationCount = async () => {
      try {
        setIsLoading(true);
        const response = await axios.get('/api/certifications/count');
        
        if (response.data.success) {
          // Animate the counter
          let start = 0;
          const end = response.data.count;
          const duration = 2000; // 2 seconds
          const stepTime = Math.abs(Math.floor(duration / end));
          
          const timer = setInterval(() => {
            start += 1;
            setCount(start);
            
            if (start >= end) {
              clearInterval(timer);
            }
          }, stepTime);

          return () => clearInterval(timer);
        } else {
          setError('Failed to fetch certification count');
        }
      } catch (err) {
        setError('Error fetching certification count');
        console.error(err);
      } finally {
        setIsLoading(false);
      }
    };

    fetchCertificationCount();
  }, []);

  if (isLoading) return <span>Loading...</span>;
  if (error) return <span>{error}</span>;

  return (
    <div className="certification-counter text-center my-4">
      <h3 className="display-4 fw-bold text-primary">
        {count.toLocaleString()} Certifications Created and Counting
      </h3>
    </div>
  );
};

export default CertificationCounter;