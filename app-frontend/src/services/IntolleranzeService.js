import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api'; 

const apiService = axios.create({
  baseURL: API_BASE_URL,
});

export const fetchAllergeni = async () => {
  try {
    const response = await apiService.get('/allergeni');
    console.log(response.data);
    return response.data;
  } catch (error) {
    throw error;
  }
};