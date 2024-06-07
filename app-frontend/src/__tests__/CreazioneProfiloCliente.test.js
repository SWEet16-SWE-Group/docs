import React from 'react';
import { act } from 'react-dom/test-utils';
import { render, screen, waitFor, fireEvent } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { createMemoryRouter, RouterProvider } from 'react-router-dom';
import CreazioneProfiloCliente from '../views/CreazioneProfiloCliente';
import { ContextProvider } from '../contexts/ContextProvider';
import { fetchAllergeni } from '../services/IntolleranzeService';
import axiosClient from '../axios-client';

jest.mock('../services/IntolleranzeService');
jest.mock('../axios-client');

const renderWithContext = (component, initialEntries = ['/creazioneprofilocliente']) => {
    const routes = [
        {
            path: '/creazioneprofilocliente',
            element: component,
        },
    ];

    const router = createMemoryRouter(routes, {
        initialEntries,
    });

    act(() => {
        render(
            <ContextProvider>
                <RouterProvider router={router} />
            </ContextProvider>
        );
    });
};

describe('CreazioneProfiloCliente Component', () => {
    beforeEach(() => {
        jest.clearAllMocks();
        localStorage.setItem('USER_ID', '1');
    });

    it('renders the component and fetches allergeni', async () => {
        const mockAllergeni = [
            { id: '1', nome: 'Latte' },
            { id: '2', nome: 'Noci' },
        ];
        fetchAllergeni.mockResolvedValue(mockAllergeni);

        renderWithContext(<CreazioneProfiloCliente />);

        await waitFor(() => {
            expect(screen.getByText('Latte')).toBeInTheDocument();
            expect(screen.getByText('Noci')).toBeInTheDocument();
        });
    });

    it('handles loading state while fetching allergeni', async () => {
        fetchAllergeni.mockResolvedValue([]);

        renderWithContext(<CreazioneProfiloCliente />);

        expect(screen.getByText('Loading...')).toBeInTheDocument();
    });

    it('handles checkbox selection and form submission', async () => {
        const mockAllergeni = [
            { id: '1', nome: 'Latte' },
            { id: '2', nome: 'Noci' },
        ];
        fetchAllergeni.mockResolvedValue(mockAllergeni);
        axiosClient.post.mockResolvedValue({
            data: {
                status: 'success',
                notification: 'Profile created successfully',
            },
        });

        renderWithContext(<CreazioneProfiloCliente />);

        await waitFor(() => {
            expect(screen.getByText('Latte')).toBeInTheDocument();
            expect(screen.getByText('Noci')).toBeInTheDocument();
        });

        fireEvent.change(screen.getByLabelText('Username'), {
            target: { value: 'testuser' },
        });

        fireEvent.click(screen.getByLabelText('Latte'));

        fireEvent.submit(screen.getByRole('button', { name: /Conferma/i }));

        await waitFor(() => {
            expect(axiosClient.post).toHaveBeenCalledWith('/client', {
                nome: 'testuser',
                user: '1',
                allergie: ['1'],
                role: null,
            });
        });
    });

    it('displays errors if form submission fails', async () => {
        const mockAllergeni = [
            { id: '1', nome: 'Latte' },
            { id: '2', nome: 'Noci' },
        ];
        const mockError = {
            response: {
                data: {
                    errors: {
                        nome: ['Username is required'],
                    },
                },
            },
        };
        fetchAllergeni.mockResolvedValue(mockAllergeni);
        axiosClient.post.mockRejectedValue(mockError);

        renderWithContext(<CreazioneProfiloCliente />);

        await waitFor(() => {
            expect(screen.getByText('Latte')).toBeInTheDocument();
            expect(screen.getByText('Noci')).toBeInTheDocument();
        });

        fireEvent.change(screen.getByLabelText('Username'), {
            target: { value: '' },
        });

        fireEvent.submit(screen.getByRole('button', { name: /Conferma/i }));

        await waitFor(() => {
            expect(screen.getByText('Username is required')).toBeInTheDocument();
        });
    });
});
