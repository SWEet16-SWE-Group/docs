import {createBrowserRouter} from "react-router-dom";
import SignUp from "./views/SignUp.jsx";
import NotFound from "./views/NotFound.jsx";
import DefaultLayout from "./components/DefaultLayout";
import GuestLayout from "./components/GuestLayout";

const router = createBrowserRouter([
    {
        path: '/',
        element: <DefaultLayout />,
        children: [
            // decommentare qui per dashboard
            // {
            // path: '/',
            // element: <Navigate to="/dashboard" />
            // }
        ]

    },
    {
        path: '/',
        element: <GuestLayout />,
        children: [
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