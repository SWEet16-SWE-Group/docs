import React from 'react';
import { act } from 'react';
import { render, screen, waitFor, fireEvent } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { createMemoryRouter, RouterProvider } from 'react-router-dom';
import Client from '../views/Client';
import { ContextProvider } from '../contexts/ContextProvider';
import { fetchClientProfile, deleteClientProfile } from '../services/ClientService';

jest.mock('../services/ClientService');

const renderWithContext = (component, initialEntries = ['/client/1']) => {
    const routes = [
        {
            path: '/client/:clientId',
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

describe('Client Component', () => {
    beforeEach(() => {
        jest.clearAllMocks();
    });

    it('renders the client component and fetches client data', async () => {
        const mockClient = { cliente: [{ id: '1', account: 'testAccount', nome: 'testNome' }] };
        fetchClientProfile.mockResolvedValue(mockClient);

        renderWithContext(<Client />);

        await waitFor(() => {
            expect(screen.getByText('testAccount')).toBeInTheDocument();
            expect(screen.getByText('testNome')).toBeInTheDocument();
        });
    });

    it('handles loading state', async () => {
        fetchClientProfile.mockResolvedValue({ cliente: [] });

        renderWithContext(<Client />);

        expect(screen.getByText('Loading...')).toBeInTheDocument();
    });

    it('handles delete client action', async () => {
        const mockClient = { cliente: [{ id: '1', account: 'testAccount', nome: 'testNome' }] };
        fetchClientProfile.mockResolvedValue(mockClient);
        deleteClientProfile.mockResolvedValue({});

        renderWithContext(<Client />);

        await waitFor(() => {
            expect(screen.getByText('testAccount')).toBeInTheDocument();
            expect(screen.getByText('testNome')).toBeInTheDocument();
        });

        const deleteButton = screen.getByText('Delete');
        fireEvent.click(deleteButton);

        await waitFor(() => {
            expect(deleteClientProfile).toHaveBeenCalledWith('1');
        });
    });

    it('renders the client component with no data', async () => {
        fetchClientProfile.mockResolvedValue({ cliente: [] });

        renderWithContext(<Client />);

        await waitFor(() => {
            expect(screen.getByText('Loading...')).toBeInTheDocument();
        });
    });

    it('should call fetchClientProfile on mount', async () => {
        fetchClientProfile.mockResolvedValue({ cliente: [] });

        renderWithContext(<Client />);

        await waitFor(() => {
            expect(fetchClientProfile).toHaveBeenCalledTimes(1);
        });
    });

    it('should have a form with an edit button', () => {
        fetchClientProfile.mockResolvedValue({ cliente: [] });

        renderWithContext(<Client />);

        expect(screen.getByRole('button', { name: /Edit/i })).toBeInTheDocument();
    });
});
