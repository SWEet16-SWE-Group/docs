import {useState,useEffect} from 'react';
import { Form , useParams ,Outlet , useNavigate} from "react-router-dom";
import { fetchClientProfile , deleteClientProfile } from '../ClientService';



export default function Client() {
  
  const clientName = useParams();
  const [client,setClient]=useState([]);
  const navigate=useNavigate();

  async function getClient() {
    try {
      const client = await fetchClientProfile(clientName['clientId']);
      setClient(client);
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  }
  
    function deleteClient() {
      try {
        deleteClientProfile(client[0].id)
        .then(() => {
         navigate("/");
        });
    } catch(error) {
      console.error('Error deleting data:', error);
    }
  }
    useEffect(() => {
        getClient(); 
    },[]);

  return (
    <div id="client">
    {client.length ? (
            
              client.map((clientValue) => (
                <div>
                <p>{clientValue.id}</p>
                <p>{clientValue.account}</p>
                <p>{clientValue.nome}</p>
                </div>
    ))
            
          ) : (
            <p>
              <i>Loading...</i>
            </p>
          )}
          
      <div>
          <Form action="edit">
            <button type="submit">Edit</button>
          </Form>
          
            <button onClick={deleteClient}>Delete</button>
          
        </div>
        <div class="card">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
  </div>

        <div id="detail">
            <Outlet />
        </div>
    </div>
  </div>
  );
}