import {createBrowserRouter, Navigate} from "react-router-dom";
import SignUp from "./views/SignUp.jsx";
import Login from "./views/Login";
import NotFound from "./views/NotFound.jsx";

import Layout from "./components/Layout"

import ModificaInfoAccount from "./views/ModificaInfoAccount";
import SelezioneProfilo from "./views/SelezioneProfilo";
import CreazioneProfiloRistoratore from "./views/CreazioneProfiloRistoratore";
import ModificaProfiloCliente from "./views/ModificaProfiloCliente";
import ModificaProfiloRistoratore from "./views/ModificaProfiloRistoratore";
import CreazioneProfiloCliente from "./views/CreazioneProfiloCliente.jsx";
import RistoratoreDashboard from "./views/DashboardRistoratore.jsx";
import GestioneMenu from "./views/GestioneMenu.jsx";
import GestioneIngredienti from "./views/GestioneIngredienti.jsx";
import FormPietanza from "./views/FormPietanza.jsx";
import FormIngrediente from "./views/FormIngredienti.jsx";

import Ristoranti from "./views/Ristoranti";
import Ristorante from "./views/Ristorante";
import Menu from "./views/Menu";

import {useStateContext} from "./contexts/ContextProvider";

function Autenticato ({Content}) {
  const {token} = useStateContext()
  if(!token){
    return <Navigate to={"/Login"} />
  }
  return <Layout Content={Content} />
};

function Cliente ({Content}) {
  const {role} = useStateContext()
  if (role !== 'CLIENTE') {
    return <Navigate to={"/Login"} />
  }
  return <Layout Content={Content} />
}

function Ristoratore ({Content}) {
  const {role} = useStateContext()
  if (role !== 'RISTORATORE') {
    return <Navigate to={"/Login"} />
  }
  return <Layout Content={Content} />
}

const router = createBrowserRouter([
    // ANONIMO
    {
        path: '/ristoranti',
        element: <Layout Content={<Ristoranti />} />
    },
    {
        path: '/ristorante/:id',
        element: <Layout Content={<Ristorante />} />
    },
    {
        path: '/menu/:id',
        element: <Layout Content={<Menu />} />
    },
    {
        path: '/login',
        element: <Layout Content={<Login />} />,
    },
    {
        path: '/signup',
        element: <Layout Content={<SignUp />} />,
    },

    // AUTENTICATO
    {
        path: '/selezioneprofilo',
        element: <Autenticato Content={<SelezioneProfilo />} />
    },
    {
        path: '/selezioneprofilo',
        element: <Autenticato Content={<SelezioneProfilo />} />
    },
    {
        path: '/creazioneprofilocliente',
        element: <Autenticato Content={<CreazioneProfiloCliente />} />
    },
    {
        path: '/creazioneprofiloristoratore',
        element: <Autenticato Content={<CreazioneProfiloRistoratore />} />
    },
    {
        path: '/modificaprofilocliente/:id',
        element: <Autenticato Content={<ModificaProfiloCliente />} />
    },
    {
        path: '/modificaprofiloristoratore/:id',
        element: <Autenticato Content={<ModificaProfiloRistoratore />} />
    },
    {
        path: '/modificainfoaccount',
        element: <Autenticato Content={<ModificaInfoAccount />} />
    },

    //CLIENTE
    {
       path: '/dashboardcliente',
       element: <Cliente Content={<NotFound />} />
    },

    //RISTORATORE
    {
        path: '/dashboardristoratore',
        element: <Ristoratore Content={<RistoratoreDashboard />} />,
    },
    {
        path: '/gestionemenu/:ristoratoreId',
        element: <Ristoratore Content={<GestioneMenu />} />,
    },
    {
        path: '/creapietanza/:ristoratoreId',
        element: <Ristoratore Content={<FormPietanza />} />,
    },
    {
        path: '/gestioneingredienti/:ristoratoreId',
        element: <Ristoratore Content={<GestioneIngredienti />} />,
    },
    {
        path: 'creaingrediente/:ristoratoreId',
        element: <Ristoratore Content={<FormIngrediente />} />,
    },

    // 404
    {
        path: '*',
        element: <Layout Content={<NotFound />} />,
    },
])

export default router;
