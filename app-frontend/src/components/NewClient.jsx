import { useEffect} from "react";
import {useState} from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import { fetchAllergeni } from "../services/IntolleranzeService";
import ContextProvider from "../contexts/ContextProvider";

export default function NewClient() {

  const [formData, setFormData] = useState({
    account_id: localStorage.getItem('USER_ID'),
    nome: ''
    
});

const [allergeni,setAllergeni] = useState([]);

//selectedIds rappresenta gli allergeni selezionati
const [selectedIds, setSelectedIds] = useState([]);

   const handleCheckboxChange = (event) => {
   const checkedId = event.target.value;
   if(event.target.checked){
    setSelectedIds([...selectedIds,checkedId])
   }else{
    setSelectedIds(selectedIds.filter(id=>id !== checkedId))
   }
   }

async function getAllergeni() {
  try {
    const allergeni = await fetchAllergeni();
    setAllergeni(allergeni);
  } catch (error) {
    console.error('Error fetching allergeni:', error);
  }
}

useEffect( () => {
 getAllergeni();
},[]); 

const navigate=useNavigate();

const [message,setMessage] = useState();

const handleChange = (e) => {
    setFormData({
        ...formData,
        [e.target.name]: e.target.value
    });
};

        
const handleSubmit = (event) => {
      event.preventDefault();
      const api = axios.create({
        baseURL: 'http://localhost:8000/api'
      });

      api.post('/account',{
                  clientData: formData,
                  allergie: selectedIds
                })
  .then(function (response) {
    // handle success
   // setMessage(response.data.message);
    console.log(response);
    navigate("/");
  })
  .catch(function (error) {
    setMessage(error.response.data.errors["clientData.nome"]);
    setFormData({
      account_id: localStorage.getItem('USER_ID'),
      nome: ''
    }
    );
    console.log(error);
  });
}

    return(
        <div>
          <h1>Inserisci i tuoi dati</h1>
          {message && <div><p>{message}</p></div>}
            <form onSubmit={handleSubmit} >
                <input type="text" id="nome" name="nome" value={formData.nome} onChange={handleChange} placeholder="username" />
                { allergeni.length === 0 ? (<p>Loading...</p>) : (
               <div> 
                {allergeni.map((allergene) => {
                  return (
                  <div class="form-check">
                  <input 
                  class="form-check-input" 
                  type="checkbox" 
                  value={allergene.id} 
                  id={allergene.id}
                  onChange={(event) => { handleCheckboxChange(event) }
                  } />
                  <label class="form-check-label" for={allergene.id}>
                   {allergene.nome}
                  </label>
                </div>);
                })}
               </div>)}
                <button>Crea il nuovo profilo!</button>
            </form>
        </div>
    );

}

