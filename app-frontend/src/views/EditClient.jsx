import {  useParams , useNavigate} from "react-router-dom";
import {useState , useEffect } from 'react';
import { fetchClientProfile , deleteClientProfile } from '../ClientService';
import axios from 'axios';

export default function EditClient() {
  
  const clientName = useParams();
  let baseUrl =  "http://localhost:8000/api/account/".concat(clientName['clientId']);
  
  const [formData, setFormData] = useState({
    id:'',
    account: '',
    nome: '',
    created_at: '',
    updated_at:'',
    
});

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
        axios.put('http://localhost:8000/api/account',formData)
    .then(function (response) {
      // handle success
      setMessage(response.data.message);
      console.log(response);
    })
    .catch(function (error) {
      // handle error
      console.log(error);
    })
    .finally(function () {
      // always executed
      navigate("/");
    });
  }


  async function getClient() {
    try {
       const data = await fetchClientProfile(clientName['clientId']);
       setFormData(data.cliente);
       console.log(formData);
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  }
  

  useEffect(() => {
    
    getClient();
    
  },[]);

  return (
    <div>
    <div>  {message && <p>{message}</p>}</div>
    <div id="editClientForm" >
    {formData ? (
      <div>
      <form>
      <div class="form-group row">
        <label for="clientId" class="col-sm-2 col-form-label">ID</label>
        <div class="col-sm-10">
          <input type="text" readonly class="form-control-plaintext" id="clientId" value={formData.id}/>
        </div>
      </div>
      <div class="form-group row">
        <label for="inputAccount" class="col-sm-2 col-form-label">Account</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="inputAccount" name="account" placeholder={formData.account}  onChange={handleChange}/>
        </div>
      </div>
      <div class="form-group row">
        <label for="nome" class="col-sm-2 col-form-label">Username</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="nome" name="nome" value={formData.nome} onChange={handleChange} />
        </div>
      </div>    
      <button onClick={handleSubmit}  class="btn btn-primary mb-2">Conferma modifiche</button>
  </form>
  </div>) : (
      <p>Loading...</p>
    )

  }
    
    </div>
    </div>
  );
}