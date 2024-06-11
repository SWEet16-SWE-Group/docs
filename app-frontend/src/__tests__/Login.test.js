import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import Login from '../views/Login';
import axiosClient from '../axios-client';
import { act } from 'react';

jest.mock('../axios-client');
jest.mock('../contexts/ContextProvider', () => {
    const originalModule = jest.requireActual('../contexts/ContextProvider');
    return {
        ...originalModule,
        useStateContext: jest.fn(),
    };
});

const renderWithContext = (component) => {
    act(() => {
        render(
            <ContextProvider>
                <MemoryRouter initialEntries={['/login']}>
                    <Routes>
                        <Route path="/login" element={component} />
                    </Routes>
                </MemoryRouter>
            </ContextProvider>
        );
    });
};

describe('Login tests', () => {
    let mockUseStateContext;

    beforeEach(() => {
        mockUseStateContext = {
            setUser:jest.fn(),
            setRole:jest.fn(),
            setToken : jest.fn(),
            setNotification: jest.fn(),
            setNotificationStatus: jest.fn(),
        };
        useStateContext.mockReturnValue(mockUseStateContext);
    });

    afterEach(() => {
        jest.clearAllMocks();
    });

    it('Form rendered correctly', () => {
        renderWithContext(<Login/>);
        
        expect(screen.getByText('Effettua il login nel tuo account')).toBeInTheDocument();
        expect(screen.getByText('Login')).toBeInTheDocument();
        expect(screen.getByText('Crea un account')).toBeInTheDocument();

    });

    it('Form sumbmission goes smoothly', async () => {
        axiosClient.post.mockResolvedValueOnce({
            data : {
                role : 'AUTENTICATO',
                token : 'validToken',
                user : {
                    id : '1',
                }
            }
        });
        renderWithContext(<Login/>);
        act(() => {
            fireEvent.change(screen.getByPlaceholderText('Email'),{target:{value:'tullio@gmail.com'}});
            fireEvent.change(screen.getByPlaceholderText('Password'),{target:{value : 'Tulliooo'}});
            fireEvent.click(screen.getByRole('button'));
        });

        expect(axiosClient.post).toHaveBeenCalledWith('/login',{
            email: 'tullio@gmail.com',
            password: 'Tulliooo',
        });

        await waitFor(() => {
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Login effettuato con successo');
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('success');
            expect(mockUseStateContext.setToken).toHaveBeenCalledWith('validToken');
            expect(mockUseStateContext.setRole).toHaveBeenCalledWith('AUTENTICATO');
            expect(mockUseStateContext.setUser).toHaveBeenCalledWith('1');
        });

    });
    it('Form submission goes wrong', async () => {
        axiosClient.post.mockRejectedValueOnce({
            response : 
            {
                status : 422,
                data : {
                    message : 'Il login non è andato a buon fine!'
                }
        }
        });
        renderWithContext(<Login/>);
        act(() => {
            fireEvent.change(screen.getByPlaceholderText('Email'),{target:{value:'tullio@gmail.com'}});
            fireEvent.change(screen.getByPlaceholderText('Password'),{target:{value : 'Tulliooo'}});
            fireEvent.click(screen.getByRole('button'));
        });

        expect(axiosClient.post).toHaveBeenCalledWith('/login',{
            email: 'tullio@gmail.com',
            password: 'Tulliooo',
        });

        await waitFor(() => {
            expect(screen.getByText('Il login non è andato a buon fine!')).toBeInTheDocument();
            
        });

    });
});