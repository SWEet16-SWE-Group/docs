import {createBrowserRouter, Navigate} from "react-router-dom";
import SignUp from "./views/SignUp.jsx";
import Login from "./views/Login";
import NotFound from "./views/NotFound.jsx";
import AuthenticatedLayout from "./components/AuthenticatedLayout";
import GuestLayout from "./components/GuestLayout";
import ClientLayout from "./components/ClientLayout"
import RestaurantLayout from "./components/RestaurantLayout"
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

const router = createBrowserRouter([
    {
        path: '/',
        element: <AuthenticatedLayout />,
        children: [
            {
                path: '/selezioneprofilo',
                element: <SelezioneProfilo />
            },
            {
                path: '/creazioneprofilocliente',
                element: <CreazioneProfiloCliente />
            },
            {
                path: '/creazioneprofiloristoratore',
                element: <CreazioneProfiloRistoratore />
            },
            {
                path: '/modificaprofilocliente/:id',
                element: <ModificaProfiloCliente />
            },
            {
                path: '/modificaprofiloristoratore/:id',
                element: <ModificaProfiloRistoratore/>
            },
            {
                path: '/modificainfoaccount',
                element: <ModificaInfoAccount />
            },
            {
                path: '*',
                element: <NotFound />
            }
        ]
    },
    {
        path: '/',
        element: <ClientLayout />,
        children: [

            // decommentare qui per dashboard
             {
                path: '/',
                element: <Navigate to="/dashboardcliente" />
             },
            /*
            {
                path: '/ristoranti',
                element: <Ristoranti />
            },
            */
             {
                path: '/dashboardcliente',
                element: <NotFound />
             },
        ]
    },
    {
        path: '/',
        element: <RestaurantLayout />,
        children: [
            // decommentare qui per dashboard
            {
                path: '/',
                element: <Navigate to="/dashboardristoratore" />
            },
            /*
            {
                path: '/ristoranti',
                element: <Ristoranti />
            },
            */
            {
                path: '/dashboardristoratore',
                element: <RistoratoreDashboard />
            },
            {
                path: '/gestionemenu/:ristoratoreId',
                element: <GestioneMenu />
            },
            {
                path: '/creapietanza/:ristoratoreId',
                element: <FormPietanza />
            },
            {
                path: '/gestioneingredienti/:ristoratoreId',
                element: <GestioneIngredienti/>
            },
            {
                path: 'creaingrediente/:ristoratoreId',
                element: <FormIngrediente />
            },
        ]
    },
    {
        path: '/',
        element: <GuestLayout />,
        children: [
            {
                path: '/ristoranti',
                element: <Ristoranti />
            },
            {
                path: '/ristorante/:id',
                element: <Ristorante />
            },
            {
                path: '/menu/:id',
                element: <Menu />
            },
            {
                path: '/login',
                element: <Login />
            },
            {
                path: '/signup',
                element: <SignUp />
            },
            {
                path: '*',
                element: <NotFound />
            }
        ]
    },
])

export default router;
