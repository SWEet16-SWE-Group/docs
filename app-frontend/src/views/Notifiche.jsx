import {useEffect, useRef, useState} from "react";
import {Link, useNavigate} from "react-router-dom";
import axiosClient from "../axios-client.js";
import {createRef} from "react";
import {useStateContext} from "../contexts/ContextProvider.jsx";
import RestaurantCard from "../components/RestaurantCard.jsx";

function riga(a){
  a = ({
  })[a.significato](a);
  return <tr><td>{a.time}</td><td>{a.desc}</td></tr>;
}

export default function Notifiche() {
    const {role, profile} = useContext();
    const [notifiche, setNotifiche] = useState(null);

    async function fetch(){
      const {data: data} = await axiosClient.get(`/notifiche_info/${role}/${profile}`);
      setNotifiche(data);
    }

    //useEffect(() => { fetch(); }, []);

    return (
        <div>
          <table>
            <thead>
              <tr>
                <th>Tempo</th>
                <th>Descrizione</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
    )
}
