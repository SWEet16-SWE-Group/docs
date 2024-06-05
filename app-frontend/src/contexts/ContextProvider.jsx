import {createContext, useContext, useState} from "react";

const StateContext = createContext({

    currentUser: null,
    token: null,
    role : null,
    profile: null,
    ristoratore: null,
    notification: null,
    notificationStatus: null,
    setUser: () => {},
    setToken: () => {},
    setRole: () => {},
    setProfile: () => {},
    setRistoratore: () => {},
    setNotification: () => {},
    setNotificationStatus: () => {}
})

export const ContextProvider = ({children}) => {
    const [user, _setUser] = useState(localStorage.getItem('USER_ID'));
    const [role, _setRole] = useState(localStorage.getItem('ROLE'));
    const [token, _setToken] = useState(localStorage.getItem('ACCESS_TOKEN'));
    const [profile, _setProfile] = useState(localStorage.getItem('PROFILE_ID'));
    const [ristoratore, _setRistoratore] = useState(localStorage.getItem('RISTORATORE_ID'));
    const [notification, _setNotification] = useState('');
    const [notificationStatus, setNotificationStatus] = useState('failure');

    const setToken = (token) => {
        _setToken(token)

        if (token){
            localStorage.setItem('ACCESS_TOKEN', token);
        } else {
            localStorage.removeItem('ACCESS_TOKEN');
        }
    }

    const setRole = (role) => {
        _setRole(role)

        if(role) {
            localStorage.setItem('ROLE', role);
        } else {
            localStorage.removeItem('ROLE');
        }
    }

    const setUser = (user) => {
        _setUser(user)

        if(user) {
            localStorage.setItem('USER_ID', user);
        } else {
            localStorage.removeItem('USER_ID');
        }
    }

    const setProfile = (profile) => {
        _setProfile(profile)

        if(profile) {
            localStorage.setItem('PROFILE_ID',profile);
        } else {
            localStorage.removeItem('PROFILE_ID');
        }
    }

    const setRistoratore = (ristoratore) => {
        _setRistoratore(ristoratore)

        if (ristoratore) {
            localStorage.setItem('RISTORATORE_ID', ristoratore['id']);
        } else {
            localStorage.removeItem('RISTORATORE_ID');
        }
    }

    const setNotification = (message) => {
        _setNotification(message)

        setTimeout( () => {
            _setNotification('')
        }, 5000)
    }


    return (
        <StateContext.Provider value={{
            user,
            token,
            role,
            profile,
            ristoratore,
            notification,
            notificationStatus,
            setUser,
            setToken,
            setRole,
            setProfile,
            setRistoratore,
            setNotification,
            setNotificationStatus
        }}>
            {children}
        </StateContext.Provider>
    )
}

export const useStateContext = () => useContext(StateContext)
