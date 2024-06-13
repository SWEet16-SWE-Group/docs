import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import Ristorante from '../views/Ristorante';
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
                <MemoryRouter initialEntries={['/ristorante/ristorante_id']}>
                    <Routes>
                        <Route path="/ristorante/:id" element={component} />
                    </Routes>
                </MemoryRouter>
            </ContextProvider>
        );
    });
};

describe('Testing Ristorante', () => {
    const ristoratoreId = '12345';
    let mockUseStateContext;

    afterEach(() => {
        jest.clearAllMocks();
    });

    it('Initial rendering and restaurant data fetching',async () => {

        mockUseStateContext = {
            role:'CLIENTE',
        };
        useStateContext.mockReturnValue(mockUseStateContext);

        axiosClient.get.mockResolvedValueOnce({
            data : {
                id : 'ristorante_id',
                nome : 'Da Luigi',
                indirizzo :'Bologna',
                telefono : '123456789',
                orario : '19:30-22-30',
            }
        });

        renderWithContext(<Ristorante/>);
        expect(axiosClient.get).toHaveBeenCalledWith('/ristorante/ristorante_id');

        await waitFor(() => {
            expect(screen.getByText(/Da Luigi/i)).toBeInTheDocument();
            expect(screen.getByText(/Prenota/i)).toBeInTheDocument();
        });
    });

   it('Initial rendering and restaurant data fetching with anonymous Role',async () => {

        mockUseStateContext = {
            role:'',
        };
        useStateContext.mockReturnValue(mockUseStateContext);

        axiosClient.get.mockResolvedValueOnce({
            data : {
                id : 'ristorante_id',
                nome : 'Da Luigi',
                indirizzo :'Bologna',
                telefono : '123456789',
                orario : '19:30-22-30',
            }
        });

        renderWithContext(<Ristorante/>);
        expect(axiosClient.get).toHaveBeenCalledWith('/ristorante/ristorante_id');

        await waitFor(() => {
            expect(screen.getByText(/Da Luigi/i)).toBeInTheDocument();
            expect(screen.getByText(/Devi loggarti per prenotare!/i)).toBeInTheDocument();
        });
    });
});