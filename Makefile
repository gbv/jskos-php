info:
	@echo "Usage: make install|test|debug|style"

# pass any target to composer
$(MAKECMDGOALS):
	composer $(MAKECMDGOALS)
