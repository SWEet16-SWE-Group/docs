import {Outlet , Link,Form} from "react-router-dom";
import {useState , useEffect } from 'react';
import { fetchClientProfiles } from "../ClientService";



export default function Account() {
    const [clients,setClients]=useState([]);

    async function getClients() {
      try {
        const clients = await fetchClientProfiles();
        setClients(clients);
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    }

    useEffect(() => {
      getClients();
    },[]);

    return (
      <>
        <div id="sidebar">
          <h1>Profili</h1>
          <div>
            <form id="search-form" role="search">
              <input
                id="q"
                aria-label="Search contacts"
                placeholder="Search"
                type="search"
                name="q"
              />
              <div
                id="search-spinner"
                aria-hidden
                hidden={true}
              />
              <div
                className="sr-only"
                aria-live="polite"
              ></div>
            </form>
            <Form  action="new" >
              <button type="submit">Nuovo Cliente</button>
            </Form>
          </div>
          <nav>
          {clients.length ? (
            <ul class="list-group">
              {clients.map((client) => (
                <li key={client.nome}
                    class="list-group-item">
                  <Link to={`${client.nome}`}>
                    {client.nome}
                  </Link>
                </li>
              ))}
            </ul>
          ) : (
            <p>
              <i>No contacts</i>
            </p>
          )}
          </nav>
        </div>
        <div id="detail">
            <Outlet />
        </div>
      </>
    );
  }
 