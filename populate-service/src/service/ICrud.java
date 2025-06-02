package service;

import java.util.List;

public interface ICrud {
  void inserir(IGenericData entidade);

  void update(int id, IGenericData entidade);

  void delete(int id);

  List<IGenericData> read();

  IGenericData readById(int id);
}
