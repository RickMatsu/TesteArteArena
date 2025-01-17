import React, { useState, useEffect } from "react";
import { TextField, Autocomplete, CircularProgress } from "@mui/material";
import axios from "axios";

const AutoCompleteItems = () => {
  const [options, setOptions] = useState([]); // Lista de itens
  const [inputValue, setInputValue] = useState(""); // Valor digitado pelo usuário
  const [loading, setLoading] = useState(false); // Estado de carregamento
  const [open, setOpen] = useState(false); // Estado de abertura do dropdown

  // Função para buscar itens do backend
  const fetchItems = async (query) => {
    setLoading(true);
    try {
      const response = await axios.get(`/api/items`, { params: { search: query } });
      setOptions(response.data.data); // Atualizar opções com os dados da API
    } catch (error) {
      console.error("Erro ao buscar itens:", error);
    } finally {
      setLoading(false);
    }
  };

  // Atualizar lista de itens conforme o usuário digita
  useEffect(() => {
    if (inputValue) {
      fetchItems(inputValue);
    } else {
      setOptions([]);
    }
  }, [inputValue]);

  // Adicionar uma nova opção ao backend
  const handleAddOption = async (newValue) => {
    try {
      const response = await axios.post(`/api/items`, { name: newValue });
      const newItem = response.data; // Supondo que a API retorne o item recém-criado
      setOptions((prevOptions) => [...prevOptions, newItem]);
    } catch (error) {
      console.error("Erro ao adicionar item:", error);
    }
  };

  return (
    <Autocomplete
      open={open}
      onOpen={() => setOpen(true)}
      onClose={() => setOpen(false)}
      options={options}
      getOptionLabel={(option) => option.title || ""} // Nome do item (usei "title" com base no seu retorno da API)
      filterOptions={(x) => x} // Não filtrar no front, delega ao backend
      loading={loading}
      freeSolo // Permite adicionar uma nova opção
      onInputChange={(event, value) => setInputValue(value)}
      onChange={(event, value) => {
        if (value && !options.find((option) => option.title === value)) {
          handleAddOption(value); // Adicionar nova opção, se necessário
        }
      }}
      renderInput={(params) => (
        <TextField
          {...params}
          label="Pesquisar ou adicionar"
          InputProps={{
            ...params.InputProps,
            endAdornment: (
              <>
                {loading ? <CircularProgress size={20} /> : null}
                {params.InputProps.endAdornment}
              </>
            ),
          }}
        />
      )}
    />
  );
};

export default AutoCompleteItems;
