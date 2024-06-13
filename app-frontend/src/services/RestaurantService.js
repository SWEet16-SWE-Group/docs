import axiosClient from '../axios-client.js';



//funzione per reperire ristoranti secondo i parametri della query
 const fetchRestaurants = async (queryParams) => {
  try {
    console.log(queryParams);
    const response = await axiosClient.get('/search',{params : queryParams});
    console.log(response.data);
    return response.data;
  } catch (error) {
    throw error;
  }
};

export default fetchRestaurants;
