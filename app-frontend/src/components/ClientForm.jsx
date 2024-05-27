import {createRef} from "react";
import {useState} from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";

export default function ClientForm() {
    
  const [formData, setFormData] = useState({
    id:'',
    account: '',
    nome: ''
    
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
      axios.post('http://localhost:8000/api/account',formData)
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
    navigate('/');
  });
}

    return(
        <div>
          <h1>Inserisci i tuoi dati</h1>
          {message && <div><p>{message}</p></div>}
            <form onSubmit={handleSubmit} >
                <input type="text" id="id" name="id" value={formData.id} placeholder="id" onChange={handleChange}/>
                <input type="text" id="account" name="account" value={formData.account} onChange={handleChange} placeholder="account" />
                <input type="text" id="nome" name="nome" value={formData.nome} onChange={handleChange} placeholder="username" />
                <div class="allergeniCheckBoxes">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1"/>
                <label class="form-check-label" for="defaultCheck1">
                    Graminacee
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1"/>
                <label class="form-check-label" for="defaultCheck1">
                  Crostacei
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1"/>
                <label class="form-check-label" for="defaultCheck1">
                  Lattosio
                </label>
                </div>
                </div>
                <button>Crea il nuovo profilo!</button>
            </form>
        </div>
    );

}