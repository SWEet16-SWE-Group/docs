import React from 'react';
import ReactDom from "react-dom/client";
import {createBrowserRoute,
        RouterProvider,
} from "react-router-dom";
import ClientForm from "./components/ClientForm";

const Router =createBrowserRouter([
  {
    path : "/",
    element : <Account />,
  },
]);

export default function App() {

 

// Make a request for a user with a given ID

  
  return (
    <div>
      <ClientForm/>
    </div>
  );
}


