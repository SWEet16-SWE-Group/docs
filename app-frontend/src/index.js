import React from 'react';
import ReactDOM from "react-dom/client";
import {createBrowserRouter,
        RouterProvider,
} from "react-router-dom";
import './index.css';
import * as serviceWorker from './serviceWorker';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import Account from "./views/Account";
import Client,{loader as clientLoader} from "./views/Client";
import ClientForm from "./components/ClientForm";
import EditClient from "./views/EditClient";
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.css';
import { ContextProvider } from './contexts/ContextProvider';


const router = createBrowserRouter([
    {
      path : "/",
      element : <Account />,
    },

    {
        path : "new",
        element : <ClientForm />,
    },
      
    {
        path : ":clientId",
        element : <Client />,
    },
            {
                path : ":clientId/edit",
                element : <EditClient/>,
            },
        
    
    

  ]);
ReactDOM.createRoot(document.getElementById('root')).render(
    <React.StrictMode>
        <ContextProvider>
        <RouterProvider router={router} />
        </ContextProvider>
    </React.StrictMode>
)

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
