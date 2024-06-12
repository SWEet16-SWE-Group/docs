import {useEffect, useRef, useState} from "react";
import axiosClient from "../axios-client";
import {Link, useNavigate, redirect} from "react-router-dom";
import {useStateContext} from "../contexts/ContextProvider";

export default function SelezioneProfilo() {

    const navigate = useNavigate();

    const {role, setRole, setProfile, setRistoratore,setNotification, setNotificationStatus } = useStateContext()
    const [ClientProfiles, setClientProfiles] = useState(null);
    const [RestaurantProfiles, setRestaurantProfiles] = useState(null);


    const [user, setUser] = useState({
        id: localStorage.getItem('USER_ID'),
    })

    const getProfiles = () => {

        const payload = {
            id: user.id,
            role: role
        };

        axiosClient.post('/profiles',payload)
            .then(({data}) => {
                setClientProfiles(data.clienti);
                console.log(ClientProfiles);
                setRestaurantProfiles(data.ristoratori);
                console.log(data.clienti);
                console.log(data.ristoratori);
                console.log(data);
            })
            .catch(err => {
                const response = err.response;
                console.error(response);
            })
    }

    useEffect(() => {
        getProfiles();
    }, [])


    const onSelectProfile = (profile, role) => {
        setProfile(profile.id);
        setRole(role);
    }


    const onModifyProfile = (profile, url) => {
        navigate(`/${url}/${profile.id}`);
    }

    const onDeleteProfile =  (profile, url) => {
        if(!window.confirm("Sei sicuro di voler eliminare questo profilo?")) {
            return
        }

        axiosClient.delete(`/${url}/${profile.id}`)
           .then((response) => {
               setNotificationStatus(response.data.status);
               setNotification(response.data.notification);
               console.log(response);
               getProfiles();
           }, null )
           .catch((error) =>  {
               setNotificationStatus(error.response.data.status);
               setNotification(error.response.data.notification);

           })
    }

    return (
        <div className="container-fluid p-auto border rounded border-2 margin-tb h-auto">
            <div>
                <Link to={'/creazioneprofilocliente'}>Crea nuovo profilo cliente</Link>
            </div>
            <div>
                <Link to={'/creazioneprofiloristoratore'}>Crea nuovo profilo ristoratore</Link>
            </div>
            <div>
                {(!ClientProfiles && !RestaurantProfiles) &&
                    <h2>
                        Non è presente nessun profilo, creane uno!
                    </h2>
                }
                {(ClientProfiles || RestaurantProfiles) &&
                    <table>
                      <thead>
                          <tr>
                            <th>Entra con questo profilo</th>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Operazioni</th>
                          </tr>
                      </thead>
                    <tbody>
                    {ClientProfiles && ClientProfiles.map(profile => (
                                        
                        <tr key={profile.id}>
                            <td>
                                <Link to="/dashboardcliente" className="btn btn-primary me-2" onClick={() =>onSelectProfile(profile,'CLIENTE')}>Seleziona</Link>
                            </td>
                            <td>{profile.nome}</td>
                            <td>Cliente</td>
                            <td>
                                <button className="btn btn-primary me-2" onClick={() => onModifyProfile(profile,'modificaprofilocliente')}>Modifica</button>
                                &nbsp;
                                <button className="btn btn-danger me-2" onClick={() => onDeleteProfile(profile,'client')}>Elimina</button>
                            </td>
                        </tr>))}
                    
                    {RestaurantProfiles && RestaurantProfiles.map(profile => (
                        <tr key={profile.id}>
                          <td>
                              <Link to="/dashboardristoratore" className="btn btn-primary me-2" onClick={() => onSelectProfile(profile,'RISTORATORE')}>Seleziona</Link>
                          </td>
                            <td>{profile.nome}</td>
                            <td>Ristoratore</td>
                            <td>
                                <button className="btn btn-primary me-2" onClick={() => onModifyProfile(profile,'modificaprofiloristoratore')}>Modifica</button>
                                &nbsp;
                                <button className="btn btn-danger me-2" onClick={() => onDeleteProfile(profile,'elimina-ristoratore')}>Elimina</button>
                            </td>
                        </tr>
                    ))}
                    </tbody>
                    </table>
                }
            </div>
        </div>
    );
}
