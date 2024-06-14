import axiosClient from '../axios-client.js';

export const fetchAllergeni = async () => {
  try {
    const response = await axiosClient.get('/allergeni');
    console.log(response.data);
    return response.data;
  } catch (error) {
    throw error;
  }
};
