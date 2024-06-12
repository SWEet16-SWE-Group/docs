import React from 'react';
import { render, screen , waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import DashBoardCliente from '../views/DashboardCliente';
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
                <MemoryRouter initialEntries={['/dashboardcliente']}>
                    <Routes>
                        <Route path="/dashboardcliente" element={component} />
                    </Routes>
                </MemoryRouter>
            </ContextProvider>
        );
    });
};

describe('RistoratoreDashboard', () => {
    const clientId = '12345';
    let mockUseStateContext;

    beforeEach(() => {
        mockUseStateContext = {
            profile: clientId,
        };
        useStateContext.mockReturnValue(mockUseStateContext);
    });

    afterEach(() => {
        jest.clearAllMocks();
    });
        
    it('Fetching reservations goes well', async () => {
        axiosClient.get.mockResolvedValueOnce({
            data : [
                {
                    id : '123',
                    orario : '20:00',
                    nome : 'Da Luigi',
                    numero_inviti : '6',
                    stato : 'Accettata',
                }
            ]
        });

        renderWithContext(<DashBoardCliente/>);
        expect(axiosClient.get).toHaveBeenCalledWith('/dashboard_c/12345');
        await waitFor( () => {
            expect(screen.getByText('Da Luigi')).toBeInTheDocument();
        });
    });
});