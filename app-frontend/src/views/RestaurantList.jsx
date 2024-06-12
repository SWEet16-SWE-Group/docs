import { useSearchParams } from 'react-router-dom';
import {useEffect, useState , useReducer } from 'react';
import { useStateContext } from '../contexts/ContextProvider.jsx';
import  fetchRestaurants  from '../services/RestaurantService';
import RestaurantCard from '../components/RestaurantCard.jsx';
import { getFilteredData  } from '../helperFunctions/getFilteredData.js';
import {reducer} from '../helperFunctions/reducer.js';

export default function RestaurantList() {

  const { setNotificationStatus, setNotification } = useStateContext();
    const [restaurants,setRestaurants] = useState([]);
    const [isLoading,setIsLoading]=useState(false);
    const [searchParams,setSearchParams]=new useSearchParams();

    const searchAsObject = Object.fromEntries(
      new URLSearchParams(searchParams)
    );
  
    console.log(searchAsObject);

    async function  getRestaurants() {
      setIsLoading(true);
        try {
            const response = await fetchRestaurants(searchAsObject);
            console.log(response);
            setRestaurants(response.listaRistoranti);
            setNotificationStatus(response.status);
            setNotification(response.notification);
            
        }
        catch (error) {
          console.log(error);
          setNotificationStatus(error.response.data.status);
          setNotification(error.response.data.notification);
        }
        setIsLoading(false);
    }
    const [orarioArrivo, setOrarioArrivo] = useState("");

    const handleTimeChange = (event) => {
      const value = event.target.value;
      setOrarioArrivo(value);
    }

    useEffect(() => {
        getRestaurants();
    },[]);

    const [
        { cusineType ,timeArrival },
        dispatch
      ] = useReducer(reducer, {
        cusineType : '',
        timeArrival : '',
      });
      const filteredData = getFilteredData(
        restaurants,
        cusineType,
        timeArrival
      );
      console.log(filteredData);
    
    return (
        <>
        <form>
        <fieldset class="form-group">
        <legend>Cucina:</legend>
        <div class="form-check">
        <label class="form-check-label" htmlFor='pizzaFilter'>
          <input class="form-check-input"
            type="checkbox"
            name="pizzaFilter"
            id='pizzFilter'
            onChange={() =>
              dispatch({ type: "FILTER", payload:'pizza' })
            }
            checked={cusineType === 'pizza'}
          />
         Pizza
        </label>
        <label class="form-check-label" htmlFor='pastaFilter'>
          <input
          class="form-check-input"
            type="checkbox"
            name="pastaFilter"
            id='pastaFilter'
            onChange={() =>
              dispatch({ type: "FILTER", payload: 'pasta' })
            }
            checked={cusineType === 'pasta'}
          />
         pasta
        </label>
        <label class="form-check-label" htmlFor='carnFilter'>
          <input
          class="form-check-input"
            type="checkbox"
            name="carneFilter"
            id='carneFilter'
            role="carneFilter"
            onChange={() =>
              dispatch({ type: "FILTER", payload: 'carne' })
            }
            checked={cusineType === 'carne'}
          />
         carne
        </label>
        <label class="form-check-label" htmlFor='pesceFilter'>
          <input
          class="form-check-input"
            type="checkbox"
            name="pesceFilter"
            id='pesceFilter'
            onChange={() =>
              dispatch({ type: "FILTER", payload: 'pesce' })
            }
            checked={cusineType === 'pesce' }
          />
         pesce
        </label>
        <label class="form-check-label" htmlFor='allCusine'>
          <input
          class="form-check-label"
            type="checkbox"
            name="allCusine"
            id='allCusine'
            onChange={() =>
              dispatch({ type: "FILTER", payload: '' })
            }
            checked={cusineType === '' }
          />
         Tutte le cucine
        </label>
        </div>
      </fieldset>
      <legend>Orario</legend>
      <fieldset>
      <label htmlFor="orario">Scegli il tuo orario di arrivo:</label>
      <input type="time" id="orario"  name="orario" min="09:00" max="24:00" role="timeArrivalFilter"
      onChange={handleTimeChange} />
      <button onClick={() => dispatch({type : "TIME" , payload: orarioArrivo })}>Applica filtro</button>
      </fieldset>
      </form>
        {
        isLoading ? 
        (
          <p>Loading ...</p>
        )  : (
        filteredData.length !== 0 ? (
            <div>
                {filteredData.map((restaurant) => {
                   return ( <RestaurantCard restaurant={restaurant.ristorante} />);
                }
            )}
            </div>
    )
        :
        (<div> Nessun ristorante corrisponde ai tuoi criteri di ricerca!</div>))
    }
        </>

    );
}