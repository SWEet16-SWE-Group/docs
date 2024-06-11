import React from 'react';
import { act } from 'react-dom/test-utils';
import { render, screen, waitFor, fireEvent } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { createMemoryRouter, RouterProvider } from 'react-router-dom';
import Account from '../views/Account';
import { ContextProvider } from '../contexts/ContextProvider';
import { fetchClientProfiles } from '../services/ClientService';

jest.mock('../services/ClientService');

const renderWithContext = (component) => {
    const routes = [
        {
            path: '/account',
            element: component,
        },
    ];

    const router = createMemoryRouter(routes, {
        initialEntries: ['/account'],
    });

    act(() => {
        render(
            <ContextProvider>
                <RouterProvider router={router} />
            </ContextProvider>
        );
    });
};

describe('Account Component', () => {
    beforeEach(() => {
        jest.clearAllMocks();
    });

    it('renders the account component with no clients', async () => {
        fetchClientProfiles.mockResolvedValue([]);

        renderWithContext(<Account />);

        await waitFor(() => {
            expect(screen.getByText('No contacts')).toBeInTheDocument();
        });
    });

    it('renders the account component with clients', async () => {
        const mockClients = [{ nome: 'Client1' }, { nome: 'Client2' }];
        fetchClientProfiles.mockResolvedValue(mockClients);

        renderWithContext(<Account />);

        await waitFor(() => {
            expect(screen.getByText('Client1')).toBeInTheDocument();
            expect(screen.getByText('Client2')).toBeInTheDocument();
        });
    });

    it('should call fetchClientProfiles on mount', async () => {
        fetchClientProfiles.mockResolvedValue([]);

        renderWithContext(<Account />);

        await waitFor(() => {
            expect(fetchClientProfiles).toHaveBeenCalledTimes(1);
        });
    });

    it('should have a form with a search input and a submit button', () => {
        renderWithContext(<Account />);

        expect(screen.getByPlaceholderText('Search')).toBeInTheDocument();
        expect(screen.getByRole('button', { name: /Nuovo Cliente/i })).toBeInTheDocument();
    });

    it('should handle search input change', () => {
        renderWithContext(<Account />);

        const searchInput = screen.getByPlaceholderText('Search');
        fireEvent.change(searchInput, { target: { value: 'Client1' } });
        expect(searchInput.value).toBe('Client1');
    });
});
